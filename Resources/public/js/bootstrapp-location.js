/*!
 * bootstrapp-location.js v1.0.0
 * jQuery Location Typeahead
 *
 * Copyright (c) 2012, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
(function ($) {
    "use strict";
    var methods, geocoderTimeoutId, originalTypeaheadSelectFunction;

    function indexOf(array, obj) {
        var i;
        for (i = 0; i < array.length; i += 1) {
            if (array[i] === obj) {
                return i;
            }
        }
        return -1;
    }

    function findInfo(result, type) {
        var i, component;
        if (type === 'lat' || type === 'lng') {
            return result.geometry.location[type]();
        }
        if (result.address_components) {
            for (i = 0; i < result.address_components.length; i += 1) {
                component = result.address_components[i];
                if (indexOf(component.types, type) !== -1) {
                    return component.long_name;
                }
            }
        }
        return false;
    }

    methods = {
        init: function ($element, options) {
            var self = this;
            this.$element = $element;
            this.settings = $.extend(true, {
                map: false,
                mapStatic: false,
                mapOptions: {
                    zoom: 15,
                    center: [0, 0],
                    scrollwheel: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    marker: {
                        visible: true,
                        draggable: true
                    }
                },
                geocoderOptions: {
                    appendAddressString: '',
                    region: null,
                    reverse: true
                },
                typeaheadOptions: {
                    source: methods.source,
                    updater: methods.updater,
                    matcher: methods.matcher
                },
                callback: null,
                components: {}
            }, options);

            $.each(this.settings.typeaheadOptions, function (key, method) {
                if ($.isFunction(self.settings.typeaheadOptions[key])) {
                    self.settings.typeaheadOptions[key] = $.proxy(method, self);
                }
            });

            var components = this.settings.components;
            $.each(components, function (component, properties) {
                var element, restrict, callback;
                if ($.type(properties) === "string") {
                    element = $(properties);
                } else if ($.isPlainObject(properties)) {
                    if(properties.selector) {
                        element = $(properties.selector);
                    }
                    if($.type(properties.restrict) === "boolean") {
                        restrict = properties.restrict;
                    }
                    if($.isFunction(properties.callback)) {
                        callback = properties.callback;
                    }
                }
                components[component] = {
                    element: element,
                    restrict: restrict,
                    callback: callback
                };
            });
            this.settings.components = components;

            // hash to store geocoder results keyed by address
            this.addressMapping = {};
            this.currentItem = '';
            this.geocoder = new google.maps.Geocoder();
            this.autocomplete = new google.maps.places.AutocompleteService();
            this.placesService = null;

            if (this.settings.map) {
                methods.initMap.apply(this, undefined);
                this.placesService = new google.maps.places.PlacesService(this.gmap);
            }

            this.$element
                .attr('autocomplete', 'off')
                .typeahead(this.settings.typeaheadOptions);
            this.$element.live('keypress',function(e){
                 if(e.which==13){
                     e.preventDefault();
                     e.stopPropagation();
                     self.geocode();
                 }
             });
        },
        initMap: function () {
            if (!this.settings.map) {
                return;
            }
            var mapOptions = $.extend({}, this.settings.mapOptions),
                latLng = new google.maps.LatLng(mapOptions.center[0], mapOptions.center[1]),
                zoom = this.getZoom({geometry:{location: latLng}}),
                $mapContainer = $(this.settings.map),
                baseQueryParts;
            if (this.settings.mapStatic) {
                baseQueryParts = {
                    mapType: mapOptions.mapTypeId,
                    sensor: false,
                    size: [$mapContainer.width(), $mapContainer.height()].join('x'),
                    zoom: zoom
                };
                this.$staticGmap = $('<img/>').on('center', function (e, location) {
                    var query = [],
                        queryParts = $.extend({}, baseQueryParts, location);

                    $.each(queryParts, function (d) {
                        query.push(encodeURIComponent(d) + "=" + encodeURIComponent(queryParts[d]));
                    });
                    $(this).attr('src', '//maps.googleapis.com/maps/api/staticmap?' + query.join('&'));
                });
                this.$staticGmap.trigger('center', {
                    center: mapOptions.center.join(' ')
                });
                $mapContainer.append(this.$staticGmap);
            } else {
                mapOptions.center = latLng;
                mapOptions.zoom = zoom;
                this.gmap = new google.maps.Map($mapContainer[0], mapOptions);
                this.gmarker = new google.maps.Marker({
                    position: mapOptions.center,
                    map: this.gmap,
                    draggable: mapOptions.marker.draggable,
                    visible: mapOptions.marker.visible && (latLng.lat() != 0 || latLng.lng() != 0)
                });
                google.maps.event.addListener(this.gmarker, 'dragend', $.proxy(function(){
                    if (this.settings.geocoderOptions.reverse) {
                        var location = this.gmarker.getPosition(),
                            latLng = new google.maps.LatLng(location.lat(), location.lng());
                        this.geocode({'latLng': latLng}, $.proxy(this.parseGeocodeResult, this));
                    }
                }, this));
            }
        },
        source: function (query, process) {
            var labels, self = this;

            if (geocoderTimeoutId) {
                clearTimeout(geocoderTimeoutId);
                geocoderTimeoutId = false;
            }
            geocoderTimeoutId = setTimeout(
                function geocodeString() {
                    /*
                    self.geocode({address:query}, function (geocoderResults) {
                        self.addressMapping = {};
                        labels = [];
                        $.each(geocoderResults, function (index, element) {
                            self.addressMapping[element.formatted_address] = element;
                            labels.push(element.formatted_address);
                        });
                        return process(labels);
                    });
                    */
                    self.autocomplete.getPlacePredictions({ input: query }, function(predictions, status) {
                        self.addressMapping = {};
                        if (status == google.maps.places.PlacesServiceStatus.OK) {
                            process($.map(predictions, function(prediction) {
                                self.addressMapping[prediction.description] = prediction;
                                return prediction.description;
                            }));
                        }
                    });
                },
                250
            );
        },
        updater: function (item) {
            if (this.placesService) {
                this.placesService.getDetails(this.addressMapping[item], $.proxy(this.parsePlaceResult, this));
            } else {
                this.geocode({ address: item }, $.proxy(this.parseGeocodeResult, this));
            }
            return item;
        },
        matcher: function (item) {
            return true; // match is handled by the geocoder service
        },
        currentItemData: function () {
            return this.dataByAddress(this.$element.val());
        },
        dataByAddress: function (address) {
            return this.addressMapping[address] || {};
        },
        getZoom: function (item) {
            if (!jQuery.type(item) === "object" || !item.geometry) {
                return false;
            }
            if (this.$staticGmap && item.geometry.viewport) {
                var GLOBE_WIDTH = 256, // a constant in Google's map projection
                    west = item.geometry.viewport.getSouthWest().lng(),
                    east = item.geometry.viewport.getNorthEast().lng(),
                    angle = east - west;
                if (angle < 0) {
                    angle += 360;
                }
                return Math.round(Math.log(this.$staticGmap.width() * 360 / angle / GLOBE_WIDTH) / Math.LN2) - 2;
            } else if (item.geometry.location) {
                if (item.geometry.location.lat() == 0 && item.geometry.location.lng() == 0) {
                    return 1;
                }
            }
            var zoom = 0;
            if (item.address_components && item.address_components.length) {
                $.each(item.address_components, function(index, component){
                    $.each(component.types, function(index, type){
                        switch(type) {
                            case "street_number":
                            case "route":
                                zoom = Math.max(zoom, 15);
                                break;
                            case "postal_code":
                            case "locality":
                                zoom = Math.max(zoom, 13);
                                break;
                            case "administrative_area_level_2":
                                zoom = Math.max(zoom, 9);
                                break;
                            case "administrative_area_level_1":
                                zoom = Math.max(zoom, 7);
                                break;
                            case "country":
                                zoom = Math.max(zoom, 5);
                                break;
                            default:
                                break;
                        }
                    });
                });
            }
            if (zoom) {
                return zoom;
            }
            return this.settings.mapOptions.zoom;
        },
        geocode: function (parameters, callback) {
            if (!$.type(parameters) === "object" || $.isEmptyObject(parameters)) {
                parameters = {
                    address: $.trim(this.$element.val())
                };
            }
            if (!$.isFunction(callback)) {
                callback = $.proxy(this.parseGeocodeResult, this);
            }
            if (parameters.address) {
                parameters.address = parameters.address + this.settings.geocoderOptions.appendAddressString;
            }
            parameters = $.extend({
                    componentRestrictions: {}
                },
                parameters
            );
            if (this.settings.geocoderOptions.region) {
                parameters.region = this.settings.geocoderOptions.region;
            }
            var components = this.settings.components;
            $.each(components, function (component, properties) {
                if (properties.element && properties.element.length > 0 && true == properties.restrict) {
                    var value = properties.element.val(),
                        camelized = component.replace(/(\-|_|\s)+(.)?/g, function(match, sep, c) {
                        return (c ? c.toUpperCase() : '');
                    });
                    if (value.length > 0) {
                        switch(camelized) {
                            case 'route':
                            case 'locality':
                            case 'administrativeArea':
                            case 'postalCode':
                            case 'country':
                                parameters.componentRestrictions[camelized] = $.trim(value);
                                break;
                        }
                    }
                }
            });
            this.geocoder.geocode(parameters, callback);
        },
        parseGeocodeResult: function (results, status) {
            return this.parseData(results && results.length > 0 ? results[0] : null, status);
        },
        parsePlaceResult: function (place, status) {
            return this.parseData(place, status);
        },
        parseData: function (data, status) {
            if (status == google.maps.GeocoderStatus.OK && null != data) {
                if (!$.isFunction(this.settings.callback)) {
                    this.$element.removeClass('error');
                }

                this.addressMapping[data.formatted_address] = data;
                if (this.$staticGmap) {
                    this.$staticGmap.trigger('center', {
                        zoom: this.getZoom(data),
                        markers: [data.geometry.location.lat(), data.geometry.location.lng()].join(' ')
                    });
                }
                if (this.gmarker) {
                    this.gmarker.setPosition(data.geometry.location);
                    this.gmarker.setVisible(true);
                    this.updateViewport(data);
                }

                var self = this;
                $.each(this.settings.components, function (component, properties) {
                    if (properties.element && properties.element.length > 0) {
                        var newValue = $.isFunction(properties.callback) ? ($.proxy(properties.callback, self)(data)) : findInfo(data, component);
                        newValue = newValue || '';
                        if (properties.element.data('select2')) {
                            properties.element.select2('val', newValue);
                        } else {
                            properties.element.val(newValue);
                        }
                    }
                });
            } else if (!$.isFunction(this.settings.callback)) {
                this.$element.addClass('error');
            }

            if ($.isFunction(this.settings.callback)) {
                $.proxy(this.settings.callback, this)(data, status);
            }

            return this;
        },
        updateViewport: function(place){
            if (place.geometry.viewport) {
                this.gmap.fitBounds(place.geometry.viewport);
            } else {
                this.gmap.setCenter(place.geometry.location);
                this.gmap.setZoom(this.getZoom(place));
            }
        }
    };

    $.fn.locationTypeahead = function (method) {
        var $this = this, locationTypeahead = this.data('locationTypeahead');
        if (locationTypeahead) {
            if (typeof method === 'string' && locationTypeahead[method]) {
                return locationTypeahead[method].apply(locationTypeahead, Array.prototype.slice.call(arguments, 1));
            }
            return $.error('Method ' +  method + ' does not exist on jQuery.locationTypeahead');
        } else {
            if (!method || typeof method === 'object') {
                return this.each(function () {
                    var locationTypeahead;
                    locationTypeahead = $.extend({}, methods);
                    locationTypeahead.init($this, method);
                    $this.data('locationTypeahead', locationTypeahead);
                });
            }
            return $.error('jQuery.locationTypeahead is not instantiated. Please call $("selector").locationTypeahead({options})');
        }
    };

}(jQuery));
