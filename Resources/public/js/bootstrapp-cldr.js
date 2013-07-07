/*!
 * bootstrapp-cldr.js v1.0.0
 *
 * Copyright (c) 2012, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
(function() {
    TwitterCldr.DateTimeFormatter.prototype.parse = function(value, options) {
        var i = 0,
            pattern,
            values = value.split(/[\s\/\-\.\,\_\:]+/),
            year = 0,
            month = 0,
            day = 0,
            hours = 0,
            minutes = 0,
            seconds = 0,
            milliseconds = 0,
            date,
            timeOnly = true,
            tokens = this.get_tokens({}, options),
            $this = this;
        if(options && options.date instanceof Date) {
            date = new Date(date.getTime());
        }
        $(tokens).each(function(index, token) {
            pattern = null;
            switch (token.type) {
                case "pattern":
                    pattern = token.value[0];
                    break;
                case "plaintext":
                    break;
                default:
                    if (token.value.length > 0 && token.value[0] === "'" && token.value[token.value.length - 1] === "'") {
                        pattern = token.value.substring(1, token.value.length - 1);
                    } else {
                        pattern = token.value;
                    }
                    break;
            }
            if(pattern) {
                switch(pattern) {
                    case 'y':
                    case 'Y':
                        if(value = $this.parseYear(values[i])) {
                            year = value;
                        }
                        timeOnly = false;
                        break;
                    case 'M':
                        if(value = $this.parseMonth(values[i])) {
                            month = value;
                        }
                        timeOnly = false;
                        break;
                    case 'd':
                    case 'D':
                        if(value = $this.parseDay(values[i])) {
                            day = value;
                        }
                        timeOnly = false;
                        break;
                    case 'h':
                    case 'H':
                        if(value = $this.parseHour(values[i])) {
                            hours = value;
                        }
                        break;
                    case 'm':
                        if(value = $this.parseMinutes(values[i])) {
                            minutes = value;
                        }
                        break;
                    case 's':
                    case 'S':
                        if(value = $this.parseSeconds(values[i])) {
                            seconds = value;
                        }
                        break;
                    default :
                        break;
                }
                i++;
            }
        });
        if(!(date instanceof Date)) {
            if(!timeOnly) {
                if(year == 0) {
                    jQuery.error( 'Year is not defined!' );
                }
                if(month == 0) {
                    jQuery.error( 'Month is not defined!' );
                }
                if(day == 0) {
                    jQuery.error( 'Day is not defined!' );
                }
                date = new Date(year, month-1, day)
            } else {
                date = new Date();
            }
        } else {
            if(year) {
                date.setYear(year);
            }
            if(month) {
                date.setMonth(month-1);
            }
            if(day) {
                date.setDate(day);
            }
        }
        date.setHours(hours, minutes, seconds, 0);
        return date;
    };

    TwitterCldr.DateTimeFormatter.prototype.parseYear = function(str) {
        var value = parseInt(str);
        if(value == str) {
            return value;
        }
        return null;
    };

    TwitterCldr.DateTimeFormatter.prototype.parseMonth = function(str) {
        var value;
        if(jQuery.isNumeric(str)) {
            value = parseInt(str);
        } else {
            str = jQuery.trim(str);
            jQuery.each(TwitterCldr.Calendar.calendar.months.format.wide, function(index, month_str){
                if(month_str.toLowerCase().indexOf(str.toLowerCase()) > -1) {
                    value = index;
                    return false;
                }
            });
            if(null == value) {
                jQuery.each(TwitterCldr.Calendar.calendar.months.format.abbreviated, function(index, month_str){
                    if(month_str.indexOf(str.toLowerCase()) > -1) {
                        value = index;
                        return false;
                    }
                });
            }
        }
        return value;
    };

    TwitterCldr.DateTimeFormatter.prototype.parseDay = function(str) {
        var value = parseInt(str);
        if(value == str) {
            return value;
        }
        return null;
    };

    TwitterCldr.DateTimeFormatter.prototype.parseHour = function(str) {
        if(jQuery.isNumeric(str)) {
            return Math.min(Math.max(parseInt(str), 0), 23);
        }
        return null;
    };

    TwitterCldr.DateTimeFormatter.prototype.parseMinutes = function(str) {
        if(jQuery.isNumeric(str)) {
            return Math.min(Math.max(parseInt(str), 0), 59);
        }
        return null;
    };

    TwitterCldr.DateTimeFormatter.prototype.parseSeconds = function(str) {
        if(jQuery.isNumeric(str)) {
            return Math.min(Math.max(parseInt(str), 0), 59);
        }
        return null;
    };
})( jQuery );