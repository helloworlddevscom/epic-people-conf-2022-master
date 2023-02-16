/**
 * JS for Schedule page and Overview page.
 */

jQuery(function ($) {

  if ($('#schedule__filters').length) {
    var ajaxSent = false;
    const $checkboxGroup = $('.event-type-filter__input-group');
    const $checkbox = $('.event-type-filter__checkbox');
    const $allCheckbox = $('#All-checkbox');
    const $allMobileCheckbox = $('.schedule__filters--mobile #All-checkbox');
    const $scheduleContent = $('#schedule__content');

    // Load args from URL.
    loadArgsFromUrl();

    /**
     * Extend filter checkbox click area to label.
     */
    $checkboxGroup.each(function() {
      $('.event-type-filter__checkbox-label').off().on('click.eventTypeCheckbox tap.eventTypeCheckbox touch.eventTypeCheckbox', function() {
        var $sibling_checkbox = $(this).prev('.event-type-filter__checkbox');
        $sibling_checkbox.prop('checked', !$sibling_checkbox.prop('checked')).change();
      });
    });

    /**
     * Event type filter change event.
     * This is a weird UI where there is an "All" checkbox,
     * instead of all the checkboxes being checked by default.
     * Checking "All" should actually uncheck all the other checkboxes.
     * It is also possible for all checkboxes to be checked but "All" is not checked.
     */
    $checkbox.each(function() {
      var $this_checkbox = $(this);

      // Send AJAX request for new data on checkbox change.
      $this_checkbox.change(function(e) {
        // If checkbox is All.
        if ($this_checkbox.attr('id') == 'All-checkbox') {
          // If All is checked, uncheck all other checkboxes.
          if ($this_checkbox[0].checked) {
            $checkbox.each(function() {
              if ($(this).attr('id') !== 'All-checkbox') {
                $(this).prop('checked', false);
              }
              // Call AJAX.
              callAjax();
            })
          }
          // If there are now no other checkboxes checked, check All.
          else {
            $(this).prop('checked', true);
          }
        }
        // If checkbox is not all.
        else {
          var none_checked = checkIfNoneUnchecked();

          // If there are now no other checkboxes checked, check All.
          if (none_checked) {
            $allCheckbox.prop('checked', true);
            $allMobileCheckbox.prop('checked', true);
            // Call AJAX.
            callAjax();
          }
          // If a checkbox is checked other than All, uncheck All.
          else {
            $allCheckbox.prop('checked', false);
            $allMobileCheckbox.prop('checked', false);
            // Call AJAX.
            callAjax();
          }
        }
      });
    });

    /**
     * Returns true if no checkboxes are currently checked.
     * @returns {boolean}
     */
    function checkIfNoneUnchecked() {
      var none_checked = true;
      $checkbox.each(function() {
        if ($(this)[0].checked) {
          none_checked = false;
        }
      });

      return none_checked;
    }

    /**
     * Calls AJAX to get new schedule results based on
     * value of event type filters.
     * @param selected_options {array} Array of selected for event type filter.
     * @param args_from_url {boolean} Pass true if args were loaded from URL on page load instead
     * of from event type filter. This will prevent URL from being needlessly overwritten.
     */
    function callAjax(selected_options, args_from_url) {
      if (ajaxSent) {
        ajaxSent.abort();
      }

      if (selected_options == null) {
        // Retrieve input values.
        var selected_options = getEventTypeFilterValues();

        if (selected_options.length > 1) {
          if (selected_options[selected_options.length - 1] === 'all') {
            // On Desktop the 'all' string is added to the end of the selected_options arr
            selected_options.pop();
          } else if (selected_options[0] === 'all') {
            // On Mobile the 'all' string is added to the 0 index of the selected_options arr
            selected_options.shift();
          }
        }
      }

      ajaxSent = $.ajax({
        url: ajax_object.ajax_url,
        data: {
          action: 'schedule_filter',
          selected_options: selected_options,
        },
        type: 'POST',
        dataType: 'html',
        cache: false,
        beforeSend: function(xhr) {
        },
        success: function(data) {
          $scheduleContent.html(data);
          // Recalculate vertical positions of days
          // so that the active date link can be updated on scroll.
          calcDateLinkVertPositions();
          getActivePos();
          // Update URL.
          if (!args_from_url) {
            updateUrl(selected_options);
          }
        }
      });
    }

    /**
     * Appends arguments to URL.
     * @param options {array} Array of selection options.
     */
    function updateUrl(options) {
      var args = '';
      for (var x = 0; x < options.length; x++) {
        if (x == 0) {
          args += '?type='
        }
        else {
          args += '&type='
        }

        args += options[x];
      }

      // @TODO What is this obj supposed to be?
      var stateObj = { foo: 'event_type_args' };
      history.replaceState(stateObj, 'event_type_args', args);
    }

    /**
     * Loads args/params from URL and loads results based on args.
     */
    function loadArgsFromUrl() {
      var args = getParamMultiValues('type');
      if (args) {
        callAjax(args, true);
        setEventTypeFilterValues(args);
      }
    }

    /**
     * Gets values of param/arg from URL as comma separated string.
     * @param param_name {string} Name of param/arg to retrieve from URL.
     * @returns {array}
     */
    function getParamMultiValues(param_name) {
      var sURL = window.document.URL.toString();
      // Remove date hash.
      sURL = sURL.split('#')[0];
      var value =[];
      if (sURL.indexOf("?") > 0){
        var arrParams = sURL.split("?");
        var arrURLParams = arrParams[1].split("&");
        for (var i = 0; i<arrURLParams.length; i++){
          var sParam =  arrURLParams[i].split("=");
          if(sParam){
            if(sParam[0] == param_name){
              if(sParam.length>0){
                value.push(sParam[1].trim());
              }
            }
          }
        }
      }
      var value = value.toString();

      if (value) {
        return value.split(',');
      }
      else {
        return false;
      }
    }

    /**
     * Gets values of event type filter.
     * @returns {array} Selected options of filter.
     */
    function getEventTypeFilterValues() {
      // Retrieve input values.
      var selected_options = [];
      // Retrieve input labels.
      // var selected_options_labels = [];
      $checkbox.each(function () {
        if ($(this)[0].checked) {
          selected_options.push($(this).val());
          // selected_options_labels.push($(this).next('.event-type-filter__checkbox-label').text());
        }
      });

      return selected_options;
    }

    /**
     * Sets values of event type filter.
     * This is used when args are loaded form URL.
     * @param selected_options {array} Values of inputs that should be set to checked.
     */
    function setEventTypeFilterValues(selected_options) {
      $checkbox.each(function () {
        $(this).prop('checked', false);

        var checkbox_val = $(this).val();
        for (var x = 0; x < selected_options.length; x++) {
          if (checkbox_val == selected_options[x]) {
            $(this).prop('checked', true);
          }
        }
      });
    }


    /**
     * Filters dropdown open and close.
     */
    var $filter_toggle = $('.dropdown-filter__trigger');
    var open_body_class = 'dropdown-filter-open';
    var open_dropdown_class = 'dropdown-open';
    var $open_filter = null;

    /**
     * Filters dropdown toggle click event.
     */
    $filter_toggle.off().on('click.eventTypeFilterToggle tap.eventTypeFilterToggle touch.eventTypeFilterToggle', function(e) {
      e.stopPropagation();

      var $filter = $(this).parent();

      if (!$open_filter) {
        openDropdown($filter);
      }
      else {
        if ($open_filter[0] == $filter[0]) {
          closeDropdown($filter);
        }
        else {
          closeDropdown($open_filter);
          openDropdown($filter);
        }
      }
    });

    function openDropdown($filter) {
      // Add open classes.
      $('body').addClass(open_body_class);
      $filter.addClass(open_dropdown_class);

      // Setup close events.
      $(document).off('click.eventTypeFilterClose tap.eventTypeFilterClose touch.eventTypeFilterClose', function(e) {
        e.stopPropagation();
        handleOpenFilterClick($filter);
      });
      $(document).on('click.eventTypeFilterClose tap.eventTypeFilterClose touch.eventTypeFilterClose', function(e) {
        e.stopPropagation();
        handleOpenFilterClick(e, $filter)
      });

      $open_filter = $filter;
    }

    function closeDropdown($filter) {
      $('body').removeClass(open_body_class);
      $filter.removeClass(open_dropdown_class);
      $(document).off('click.eventTypeFilterClose tap.eventTypeFilterClose touch.eventTypeFilterClose');

      $open_filter = null;
    }

    function handleOpenFilterClick(e, $filter) {
      var $dropdown = $filter.find('.dropdown-filter__dropdown');

      // If click is not inside dropdown.
      if (!$(e.target).closest($dropdown).length) {
        if ($open_filter) {
          closeDropdown($filter);
        }
        e.preventDefault();
      }
      // For .date-filter, close dropdown immediately after selection is made.
      else {
        var $closest_dropdown = $(e.target).closest($dropdown);
        if ($closest_dropdown.hasClass('date-filter__dropdown')) {
          closeDropdown($filter);
        }
      }
    }


    /**
     * Date links.
     * Handles click events for desktop and mobile versions of date links.
     */
    var $date_link = $('.schedule__dates .dates__date');
    var $mobile_date_link = $('.schedule__filters--mobile .date-filter__dropdown .date-filter__date');

    // Date links desktop click events.
    $date_link.each(function(index) {
      $(this).on('click.scheduleDateClick tap.scheduleDateTap touch.scheduleDateTouch', function() {
        setActiveDate($(this));
      });
    });

    // Date links mobile click events.
    // Date links are rendered as a filter for mobile.
    $mobile_date_link.each(function(index) {
      $(this).on('click.scheduleDateClick tap.scheduleDateTap touch.scheduleDateTouch', function() {
        setActiveDate($(this));
      });
    });

    const buffer_zone = 200;
    var scroll_pos = $(window).scrollTop();
    var vert_positions = [];
    var date_link_ids = [];
    var curr_active_pos,
      curr_active_pos_key;
    calcDateLinkVertPositions();
    getActivePos();

    // console.log(vert_positions);

    /**
     * Update active date link based on scroll position.
     */
    $(window).scroll(function() {
      scroll_pos = $(window).scrollTop();
      getActivePos();
    });

    function getActivePos() {
      var new_active_pos,
        new_active_pos_key;
      for (var x = 0; x < vert_positions.length; x++) {
        // If active position is first.
        if (scroll_pos < vert_positions[1]) {
          if (curr_active_pos != vert_positions[0]) {
            new_active_pos = vert_positions[0];
            new_active_pos_key = 0;

            setActiveDate($('#date-link--' + date_link_ids[0]));
            break;
          }
        }
        // If active position is somewhere else.
        else if (scroll_pos >= vert_positions[x] && scroll_pos <= vert_positions[x + 1]) {
          if (curr_active_pos != vert_positions[x]) {
            new_active_pos = vert_positions[x];
            new_active_pos_key = x;

            setActiveDate($('#date-link--' + date_link_ids[x]));
          }
        }
        // If active position is last or
        // window is scrolled all the way to bottom.
        else if (scroll_pos >= vert_positions[vert_positions.length -1]
          || scroll_pos + $(window).height() == $(document).height()) {
          var last_key_pos = vert_positions.length - 1;
          if (curr_active_pos != vert_positions[last_key_pos]) {
            new_active_pos = vert_positions[last_key_pos];
            new_active_pos_key = last_key_pos;

            setActiveDate($('#date-link--' + date_link_ids[vert_positions.length - 1]));
            break;
          }
        }
      }

      if (new_active_pos != null && new_active_pos_key != null) {
        curr_active_pos = new_active_pos;
        curr_active_pos_key = new_active_pos_key;
      }

      // console.log(curr_active_pos, 'curr active pos');
      // console.log(curr_active_pos_key, 'curr active pos key');
    }

    function calcDateLinkVertPositions() {
      vert_positions = [];
      $('.schedule-date-anchor').each(function() {
        var position = $(this).offset().top;
        if ((position - buffer_zone) > 0 ) {
          position = position - buffer_zone;
        }

        vert_positions.push(position);
        date_link_ids.push($(this).attr('name'));
      });
    }

    function setActiveDate($active_date_link) {
      // Remove active class from all other date links.
      $date_link.removeClass('active');
      $mobile_date_link.removeClass('active');
      // Add active class to new active date link.
      $active_date_link.addClass('active');

      // Update mobile filter label.
      $('.date-filter__label .label__text').html($active_date_link.text());
    }
  }



  /**
   * Overview page functionality.
   */
  if ($('.overview-columns').length) {

    /**
     * Hacky way to trigger lightbox plugin on image click.
     */
    $('.overview-columns .wp-block-image').each(function() {
      var $parent = $(this).parent();
      var $lightbox_link = $parent.find('.wp-colorbox-youtube');
      if (!$lightbox_link.length) {
        $lightbox_link = $parent.find('.wp-colorbox-vimeo');
      }

      if ($lightbox_link.length) {
        $(this).addClass('lightbox-link-image');

        $(this).on('click tap touch', function() {
          $lightbox_link.click();
        });
      }
    });
  }
});
