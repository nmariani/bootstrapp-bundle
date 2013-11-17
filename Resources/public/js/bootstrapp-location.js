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
    var methods, geocoderTimeoutId;

    methods = {
        init: function (element, options) {
            var self = this;
            this.element = null;
            this.elements = $(element).find('input[data-location], select[data-location]');
            if ($(element).data('location')) {
                this.elements.andSelf();
            }
            this.settings = $.extend(true, {
                api: 'place',           // geocode|place
                country: '',
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
                    matcher: methods.matcher,
                    items: 10
                },
                callback: null,
                elements: {}
            }, options);

            $.each(this.settings.typeaheadOptions, function (key, method) {
                if ($.isFunction(self.settings.typeaheadOptions[key])) {
                    self.settings.typeaheadOptions[key] = $.proxy(method, self);
                }
            });

            var elements = this.elements;
            $.each(this.settings.elements, function (selector, properties) {
                var element = $(selector);
                if (element.length > 0) {
                    if ($.type(properties) === "string") {
                        element.data('location', properties);
                    } else if ($.isPlainObject(properties)) {
                        if(properties.location) {
                            element.data('location', properties.location);
                        }
                        if($.type(properties.restrict) === "boolean") {
                            element.data('restrict', properties.restrict);
                        }
                        if($.isFunction(properties.callback)) {
                            element.data('callback', properties.callback);
                        }
                        if($.type(properties.autocomplete) === "boolean") {
                            element.data('autocomplete', properties.autocomplete);
                        }
                    }
                    if (elements.find(element).length == 0) {
                        elements = elements.add(element);
                    }
                }
            });
            this.elements = elements;

            this.elements.each(function(index, element){
                element = $(element);
                if (true == element.data('autocomplete')) {
                    element.attr('autocomplete', 'off').typeahead(self.settings.typeaheadOptions);
                    element.on('focus',function(e){
                        self.element = element;
                    });
                    element.on('keypress',function(e){
                        if(e.keyCode == 13 || e.which==13){
                            e.preventDefault();
                            e.stopPropagation();
                            self.geocode();
                        }
                    });
                    if(element.data('location') == 'locality'){
                        element.on('keyup',function(e){
                            if(e.keyCode == 40 || e.which==40){
                                // force autocomplete to load localities
                                if (element.val().length == 0) {
                                    element.val(' ');
                                }
                                element.keyup();
                            }
                        });
                    }
                }
                element.blur(function(){
                    var parameters = { address: [] };
                    if (!$(this).is(self.element)) {
                        self.elements.each(function(index, element) {
                            element = $(element);
                            var value = element.val();
                            if (value.length > 0) {
                                var location = element.data('location');
                                switch (location) {
                                    case 'street_number':
                                        parameters.address.unshift(value);
                                        break;
                                    case 'route':
                                        parameters.address.push(value);
                                        break;
                                }
                            }
                        });
                        if (parameters.address.length > 0) {
                            parameters.address = parameters.address.join(' ').trim();
                        } else {
                            parameters.address = null;
                        }
                        self.geocode(parameters);
                    }
                });
            });
            this.elements.filter('select[data-location=country]').first().change(function(){
                var countries = $(this),
                    country = countries.find('option:selected'),
                    parameters = {
                        address: country.text(),
                        componentRestrictions: {}
                    };
                if (parameters.address.length > 0) {
                    self.elements.each(function(){
                        var element = $(this);
                        if (!element.is(countries)) {
                            if (element.data('select2')) {
                                element.select2('val', '');
                            } else {
                                element.val('');
                            }
                        }
                    });
                    self.geocode(parameters);
                }
            });

            // hash to store geocoder results keyed by address
            this.addressMapping = {};
            this.currentItem = '';
            this.geocoder = new google.maps.Geocoder();
            this.autocomplete = null;
            this.placesService = null;

            if (this.settings.map) {
                methods.initMap.apply(this, undefined);
            }

            if (this.settings.api == 'place') {
                this.autocomplete = new google.maps.places.AutocompleteService();
                if (this.gmap) {
                    this.placesService = new google.maps.places.PlacesService(this.gmap);
                }
            }
        },
        initMap: function () {
            if (!this.settings.map) {
                return;
            }
            // Enable the visual refresh
            google.maps.visualRefresh = true;
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
                if (0 == latLng.lat() && 0 == latLng.lng()) {
                    var countries = this.elements.filter('select[data-location=country]').first(),
                        country = countries.find('option[value=' + this.settings.country + ']'),
                        parameters = {
                            address: country.text(),
                            componentRestrictions: {}
                        };
                    if (parameters.address.length > 0) {
                        this.geocode(parameters, $.proxy(function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK && results.length > 0) {
                                var data = results[0];
                                if (this.$staticGmap) {
                                    this.$staticGmap.trigger('center', {
                                        zoom: this.getZoom(data)
                                    });
                                } else if (this.gmap) {
                                    this.updateViewport(data);
                                }
                            }
                        }, this));
                    }
                }
            }
        },
        source: function (query, process) {
            var labels,
                self = this;
            if(this.element.data('location') == 'locality'){
                query = this.elements.filter('[data-location=postal_code]').first().val() + ' ' + query;
            }
            if (geocoderTimeoutId) {
                clearTimeout(geocoderTimeoutId);
            }
            geocoderTimeoutId = setTimeout(function () {
                    if (self.placesService) {
                        var parameters = {
                            input: query,
                            types: ['geocode'],
                            componentRestrictions: {}
                        };
                        switch (self.element.data('location')) {
                            case 'locality':
                            case 'postal_code':
                            case 'country':
                            case 'administrative_area_level_1':
                            case 'administrative_area_level_2':
                                parameters.types = ['(regions)'];
                                break;
                            default:
                                parameters.types = ['geocode'];
                                break;
                        }
                        self.elements.each(function (index, element) {
                            element = $(element);
                            var value = $.trim(element.val());
                            if (element.data('restrict') && !element.is(self.element) && value.length > 0) {
                                var camelized = element.data('location').replace(/(\-|_|\s)+(.)?/g, function(match, sep, c) {
                                    return (c ? c.toUpperCase() : '');
                                });
                                switch(camelized) {
                                    //case 'route':
                                    //case 'postalCode':
                                    //case 'locality':
                                    //case 'administrativeArea':
                                    case 'country':
                                        parameters.componentRestrictions[camelized] = value;
                                        break;
                                }
                            }
                        });
                        if (!parameters.componentRestrictions.country && self.settings.country.length > 0) {
                            parameters.componentRestrictions.country = self.settings.country;
                        }
                        self.autocomplete.getPlacePredictions(parameters, function(predictions, status) {
                            self.addressMapping = {};
                            if (status == google.maps.places.PlacesServiceStatus.OK) {
                                process($.map(predictions, function(prediction) {
                                    self.addressMapping[prediction.description] = prediction;
                                    return prediction.description;
                                }));
                            }
                        });
                    } else {
                        self.geocode({ address: query }, function (geocoderResults) {
                            self.addressMapping = {};
                            labels = [];
                            $.each(geocoderResults, function (index, element) {
                                self.addressMapping[element.formatted_address] = element;
                                labels.push(element.formatted_address);
                            });
                            return process(labels);
                        });
                    }
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
        },
        matcher: function (item) {
            return true; // match is handled by the geocoder service
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
            var self = this;
            if (!$.type(parameters) === "object" || $.isEmptyObject(parameters)) {
                parameters = {
                    address: $.trim(this.element.val())
                };
            }
            if (parameters.address) {
                parameters.address = parameters.address + this.settings.geocoderOptions.appendAddressString;
            }
            if (this.settings.geocoderOptions.region) {
                parameters.region = this.settings.geocoderOptions.region;
            }
            if (!parameters.componentRestrictions) {
                parameters.componentRestrictions = {};
                this.elements.each(function (index, element) {
                    element = $(element);
                    var value = $.trim(element.val());
                    if (element.data('restrict') && !element.is(self.element) && value.length > 0) {
                        var camelized = element.data('location').replace(/(\-|_|\s)+(.)?/g, function(match, sep, c) {
                            return (c ? c.toUpperCase() : '');
                        });
                        switch(camelized) {
                            case 'route':
                            case 'locality':
                            case 'postalCode':
                            case 'country':
                                parameters.componentRestrictions[camelized] = value;
                                break;
                        }
                    }
                });
                if (!parameters.componentRestrictions.country && this.settings.country.length > 0) {
                    parameters.componentRestrictions.country = this.settings.country;
                }
            }
            if (!$.isFunction(callback)) {
                callback = $.proxy(this.parseGeocodeResult, this);
            }
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
                    this.element.removeClass('error');
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

                var callback,
                    location,
                    value,
                    components = {},
                    self = this;
                // components
                if ($.isArray(data.address_components)) {
                    $.each(data.address_components, function(index, component) {
                        $.each(component.types, function(index, type) {
                            components[type] = component;
                        })
                    })
                }
                this.elements.each(function(index, element){
                    element = $(element);
                    callback = element.data('callback');
                    location = element.data('location');
                    value = null;
                    if ($.isFunction(callback)) {
                        // callbacks
                        $.proxy(callback, self)(data);
                    } else {
                        switch (location) {
                            case 'lat':
                                // latitude
                                if (data.geometry && data.geometry.location) {
                                    value = data.geometry.location.lat();
                                }
                                break;
                            case 'lng':
                                // longitude
                                if (data.geometry && data.geometry.location) {
                                    value = data.geometry.location.lng();
                                }
                                break;
                            case 'formatted_address':
                                // full address
                                if (data.formatted_address) {
                                    value = data.formatted_address;
                                }
                                break;
                            default:
                                // components
                                if ($.type(components[location]) != 'undefined') {
                                    if (element.data('format') == 'short') {
                                        value = components[location].short_name;
                                    } else {
                                        value = components[location].long_name;
                                    }
                                }
                                break;
                        }
                    }
                    if (value && $.type(value) != 'undefined') {
                        if (element.data('select2')) {
                            element.select2('val', value);
                        } else {
                            element.val(value);
                        }
                    }
                });
            } else if (!$.isFunction(this.settings.callback)) {
                this.element.addClass('error');
            }

            // main callback
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
