/**
 * App Calendar
 */

/**
 * ! If both start and end dates are same Full calendar will nullify the end date value.
 * ! Full calendar will end the event on a day before at 12:00:00AM thus, event won't extend to the end date.
 * ! We are getting events from a separate file named app-calendar-events.js. You can add or remove events from there.
 *
 **/

'use strict';

let direction = 'ltr';

if (isRtl) {
  direction = 'rtl';
}

document.addEventListener('DOMContentLoaded', function () {
  (function () {
    const calendarEl = document.getElementById('calendar'),
      appCalendarSidebar = document.querySelector('.app-calendar-sidebar'),
      addEventSidebar = document.getElementById('addEventSidebar'),
      appOverlay = document.querySelector('.app-overlay'),
    
      offcanvasTitle = document.querySelector('.offcanvas-title'),
      btnToggleSidebar = document.querySelector('.btn-toggle-sidebar'),
      btnSubmit = document.querySelector('button[type="submit"]'),
      btnDeleteEvent = document.querySelector('.btn-delete-event'),
      btnCancel = document.querySelector('.btn-cancel'),
      eventTitle = document.querySelector('#eventTitle'),
      eventStartDate = document.querySelector('#eventStartDate'),
      eventEndDate = document.querySelector('#eventEndDate'),
      eventUrl = document.querySelector('#eventURL'),
      eventLabel = $('#eventLabel'), // ! Using jquery vars due to select2 jQuery dependency
      eventGuests = $('#eventGuests'), // ! Using jquery vars due to select2 jQuery dependency
      eventLocation = document.querySelector('#eventLocation'),
      eventDescription = document.querySelector('#eventDescription'),
      allDaySwitch = document.querySelector('.allDay-switch'),
      selectAll = document.querySelector('.select-all'),
      filterInput = [].slice.call(document.querySelectorAll('.input-filter')),
      inlineCalendar = document.querySelector('.inline-calendar'),
      task = $("#add-task"),
      color = document.querySelector('#event-color'),
      token = $('meta[name="csrf-token"]').attr('content'),
      btnCopy = document.querySelector('#btnCopy');

    let eventToUpdate,
      currentEvents = events, // Assign app-calendar-events.js file events (assume events from API) to currentEvents (browser store/object) to manage and update calender events
      isFormValid = false,
      inlineCalInstance;

    // Init event Offcanvas
    const bsAddEventSidebar = new bootstrap.Offcanvas(addEventSidebar);

    //! TODO: Update Event label and guest code to JS once select removes jQuery dependency
    // Event Label (select2)
   
   

    // Event start (flatpicker)
    if (eventStartDate) {
      var start = eventStartDate.flatpickr({
        enableTime: true,
        altFormat: 'Y-m-dTH:i:S',
        onReady: function (selectedDates, dateStr, instance) {
          if (instance.isMobile) {
            instance.mobileInput.setAttribute('step', null);
          }
        }
      });
    }

    // Event end (flatpicker)
    if (eventEndDate) {
      var end = eventEndDate.flatpickr({
        enableTime: true,
        altFormat: 'Y-m-dTH:i:S',
        onReady: function (selectedDates, dateStr, instance) {
          if (instance.isMobile) {
            instance.mobileInput.setAttribute('step', null);
          }
        }
      });
    }

    // Inline sidebar calendar (flatpicker)
    if (inlineCalendar) {
      inlineCalInstance = inlineCalendar.flatpickr({
        monthSelectorType: 'static',
        inline: true
      });
    }

    // Event click function
    function eventClick(info) {

        eventToUpdate = info.event;
        if (eventToUpdate.url) {
          info.jsEvent.preventDefault();
          window.open(eventToUpdate.url, '_blank');
        }
        bsAddEventSidebar.show();
        // For update event set offcanvas title text: Update Event
        if (offcanvasTitle) {
          offcanvasTitle.innerHTML = 'Update Event';
        }
        btnSubmit.innerHTML = 'Update';
        btnSubmit.classList.add('btn-update-event');
        btnSubmit.classList.remove('btn-add-event');
        btnDeleteEvent.classList.remove('d-none');

        start.setDate(eventToUpdate.start, true, 'Y-m-d');
        eventToUpdate.allDay === true ? (allDaySwitch.checked = true) : (allDaySwitch.checked = false);
        eventToUpdate.end !== null
          ? end.setDate(eventToUpdate.end, true, 'Y-m-d')
          : end.setDate(eventToUpdate.start, true, 'Y-m-d');
        task.val(eventToUpdate.extendedProps.task_id).trigger('change');
        color.value = eventToUpdate.backgroundColor;
       
  
        // // Call removeEvent function
        // btnDeleteEvent.addEventListener('click', e => {
        //   removeEvent(parseInt(eventToUpdate.id));
        //   // eventToUpdate.remove();
        //   bsAddEventSidebar.hide();
        // });

    }

    function eventDrop(info) {
        console.log(info.event)
        const event = info.event;
        const eventObj = {
            _token: token,
            id: event.id,
            start: event.startStr,
            end: event.end !== null
            ? event.endStr
            : event.startStr,
            allDay: event.allDay,
            color: event.backgroundColor,
            task_id: event.extendedProps.task_id
        };
        updateEvent(eventObj);
    }

    function eventResize(info) {
        const event = info.event;
        const eventObj = {
            _token: token,
            id: event.id,
            start: event.startStr,
            end: event.end !== null
            ? event.endStr
            : event.startStr,
            allDay: event.allDay,
            color: event.backgroundColor,
            task_id: event.extendedProps.task_id
        };
        updateEvent(eventObj);
    }

    // Modify sidebar toggler
    function modifyToggler() {
      const fcSidebarToggleButton = document.querySelector('.fc-sidebarToggle-button');
      fcSidebarToggleButton.classList.remove('fc-button-primary');
      fcSidebarToggleButton.classList.add('d-lg-none', 'd-inline-block', 'ps-0');
      while (fcSidebarToggleButton.firstChild) {
        fcSidebarToggleButton.firstChild.remove();
      }
      fcSidebarToggleButton.setAttribute('data-bs-toggle', 'sidebar');
      fcSidebarToggleButton.setAttribute('data-overlay', '');
      fcSidebarToggleButton.setAttribute('data-target', '#app-calendar-sidebar');
      fcSidebarToggleButton.insertAdjacentHTML('beforeend', '<i class="ti ti-menu-2 ti-sm"></i>');
    }

    // Filter events by calender
   

    // --------------------------------------------------------------------------------------------------
    // AXIOS: fetchEvents
    // * This will be called by fullCalendar to fetch events. Also this can be used to refetch events.
    // --------------------------------------------------------------------------------------------------
    function fetchEvents(info, successCallback) {
      // Fetch Events from API endpoint reference
       $.ajax(
        {
          url: 'events' + '?start=' + info.startStr + '&end=' + info.endStr,
          type: 'GET',
          success: function (result) {
            // Get requested calendars as Array
          
           
            
            console.log(result);
            successCallback(result);
            
          },
          error: function (error) {
            console.log(error);
          }
        }
      ); 

    
      // We are reading event object from app-calendar-events.js file directly by including that file above app-calendar file.
      // You should make an API call, look into above commented API call for reference
    
      // if (selectedEvents.length > 0) {
      
      // }
    }

    // Init FullCalendar
    // ------------------------------------------------
    let calendar = new Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: fetchEvents,
      plugins: [dayGridPlugin, interactionPlugin, listPlugin, timegridPlugin],
      editable: true,
      dragScroll: true,
      dayMaxEvents: 2,
      eventResizableFromStart: true,
      customButtons: {
        sidebarToggle: {
          text: 'Sidebar'
        }
      },
      headerToolbar: {
        start: 'sidebarToggle, prev,next, title',
        end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      direction: direction,
      initialDate: new Date(),
      navLinks: true, // can click day/week names to navigate views
      eventClassNames: function ({ event: calendarEvent }) {
        const colorName = calendarEvent.color;
        // Background Color
        return colorName;
     
      },
      dateClick: function (info) {
        let date = moment(info.date).format('YYYY-MM-DD');
        resetValues();
        bsAddEventSidebar.show();

        // For new event set offcanvas title text: Add Event
        if (offcanvasTitle) {
          offcanvasTitle.innerHTML = 'Add Event';
        }
        btnSubmit.innerHTML = 'Add';
        btnSubmit.classList.remove('btn-update-event');
        btnSubmit.classList.add('btn-add-event');
        btnDeleteEvent.classList.add('d-none');
        eventStartDate.value = date;
        eventEndDate.value = date;
      },
      eventClick: function (info) {
        eventClick(info);
      },
      datesSet: function () {
        modifyToggler();
      },
      viewDidMount: function () {
        modifyToggler();
      },
      //event drag and drop
      eventDrop: function (info) {
        eventDrop(info);
      },
     eventResize: function (info) {
        eventResize(info);
     }
    });

    // Render calendar
    calendar.render();
    // Modify sidebar toggler
    modifyToggler();

    const eventForm = document.getElementById('eventForm');
    const fv = FormValidation.formValidation(eventForm, {
      fields: {
        task: {
          validators: {
            notEmpty: {
              message: 'Please Select Task '
            }
          }
        },
        eventStartDate: {
          validators: {
            notEmpty: {
              message: 'Please enter start date '
            }
          }
        },
        eventEndDate: {
          validators: {
            notEmpty: {
              message: 'Please enter end date '
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          eleValidClass: '',
          rowSelector: function (field, ele) {
            // field is the field name & ele is the field element
            return '.mb-3';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    })
      .on('core.form.valid', function () {
        // Jump to the next step when all fields in the current step are valid
        isFormValid = true;
      })
      .on('core.form.invalid', function () {
        // if fields are invalid
        isFormValid = false;
      });

    // Sidebar Toggle Btn
    if (btnToggleSidebar) {
      btnToggleSidebar.addEventListener('click', e => {
        btnCancel.classList.remove('d-none');
      });
    }

    // Add Event
    // ------------------------------------------------
    function addEvent(eventData) {
      // ? Add new event data to current events object and refetch it to display on calender
      // ? You can write below code to AJAX call success response
      
      $.ajax(
        {
            url: 'events',
            type: 'POST',
            data: eventData,
            success: function (result) {
                // Get requested calendars as Array
                if(result.status == 'success'){
                    console.log(result);
                    calendar.refetchEvents();
                    bsAddEventSidebar.hide();
                }else{
                    alert(result.error);
                }
                
            },
            error: function (error) {
                console.log(error);
            }
        }
        );

 

      // ? To add event directly to calender (won't update currentEvents object)
      // calendar.addEvent(eventData);
    }

    // Update Event
    // ------------------------------------------------
    function updateEvent(eventData) {
      // ? Update existing event data to current events object and refetch it to display on calender
      // ? You can write below code to AJAX call success response
      eventData.id = parseInt(eventData.id);
      
      $.ajax({
            url: 'events/update',
            type: 'POST',
            data: eventData,
            success: function (result) {
                // Get requested calendars as Array
                if(result.status == 'success'){
                    console.log(result);
                    calendar.refetchEvents();
                    bsAddEventSidebar.hide();
                }else{
                    alert(result.error);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
  
    

      // ? To update event directly to calender (won't update currentEvents object)
      // let propsToUpdate = ['id', 'title', 'url'];
      // let extendedPropsToUpdate = ['calendar', 'guests', 'location', 'description'];

      // updateEventInCalendar(eventData, propsToUpdate, extendedPropsToUpdate);
    }

    // Remove Event
    // ------------------------------------------------

    function removeEvent(eventId) {
      // ? Delete existing event data to current events object and refetch it to display on calender
      // ? You can write below code to AJAX call success response
     
      $.ajax({
            url: 'events/delete',
            type: 'POST',
            data: {
                _token:token,
                id:eventId
            },
            success: function (result) {
                // Get requested calendars as Array
                if(result.status == 'success'){
                    console.log(result);
                    calendar.refetchEvents();
                    bsAddEventSidebar.hide();
                }else{
                    alert(result.error);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
            

      // ? To delete event directly to calender (won't update currentEvents object)
      // removeEventInCalendar(eventId);
    }

    // (Update Event In Calendar (UI Only)
    // ------------------------------------------------
    const updateEventInCalendar = (updatedEventData, propsToUpdate, extendedPropsToUpdate) => {
      const existingEvent = calendar.getEventById(updatedEventData.id);

      // --- Set event properties except date related ----- //
      // ? Docs: https://fullcalendar.io/docs/Event-setProp
      // dateRelatedProps => ['start', 'end', 'allDay']
      // eslint-disable-next-line no-plusplus
      for (var index = 0; index < propsToUpdate.length; index++) {
        var propName = propsToUpdate[index];
        existingEvent.setProp(propName, updatedEventData[propName]);
      }

      // --- Set date related props ----- //
      // ? Docs: https://fullcalendar.io/docs/Event-setDates
      existingEvent.setDates(updatedEventData.start, updatedEventData.end, {
        allDay: updatedEventData.allDay
      });

      // --- Set event's extendedProps ----- //
      // ? Docs: https://fullcalendar.io/docs/Event-setExtendedProp
      // eslint-disable-next-line no-plusplus
      for (var index = 0; index < extendedPropsToUpdate.length; index++) {
        var propName = extendedPropsToUpdate[index];
        existingEvent.setExtendedProp(propName, updatedEventData.extendedProps[propName]);
      }
    };

    // Remove Event In Calendar (UI Only)
    // ------------------------------------------------
    function removeEventInCalendar(eventId) {
      calendar.getEventById(eventId).remove();
    }

    // Add new event
    // ------------------------------------------------
    btnSubmit.addEventListener('click', e => {
      if (btnSubmit.classList.contains('btn-add-event')) {
        if (isFormValid) {
          let newEvent = {
            _token:token,
            task_id: task.val(),
            start: eventStartDate.value,
            end: eventEndDate.value,
            color: color.value,
            allDay: allDaySwitch.checked ? true : false,
          };
          addEvent(newEvent);
         // bsAddEventSidebar.hide();
        }
      } else {
        // Update event
        // ------------------------------------------------
        if (isFormValid) {
          let eventData = {
            _token:token,
            id: eventToUpdate.id,
            task_id: eventToUpdate.extendedProps.task_id,
            start: eventStartDate.value,
            end: eventEndDate.value,
            color: color.value,
            allDay: allDaySwitch.checked ? true : false
          };

          updateEvent(eventData);
         // bsAddEventSidebar.hide();
        }
      }
    });

    // Call removeEvent function
    btnDeleteEvent.addEventListener('click', e => {
        if(confirm('Are you sure you want to delete this event?')){
            removeEvent(parseInt(eventToUpdate.id));
          }
      // eventToUpdate.remove();
      bsAddEventSidebar.hide();
    });

    btnCopy.addEventListener('click', e => {
        // Copy event
        if(confirm('Are you sure you want to copylast week events?')){
            
            $.ajax({
                url: 'events/copy',
                type: 'POST',
                data: {
                    _token:token,
                },
                success: function (result) {
                    // Get requested calendars as Array
                    if(result.status == 'success'){
                        calendar.refetchEvents();
                        alert("Events copied successfully")
                    }else{
                        alert(result.error);
                    }
                }
            });
        }
    });

    // Reset event form inputs values
    // ------------------------------------------------
    function resetValues() {
      eventEndDate.value = '';
      eventStartDate.value = '';
      allDaySwitch.checked = false;
      color.value = '';
      task.val('').trigger('change');
    }

    // When modal hides reset input values
    addEventSidebar.addEventListener('hidden.bs.offcanvas', function () {
      resetValues();
    });

    // Hide left sidebar if the right sidebar is open
    btnToggleSidebar.addEventListener('click', e => {
      if (offcanvasTitle) {
        offcanvasTitle.innerHTML = 'Add Event';
      }
      btnSubmit.innerHTML = 'Add';
      btnSubmit.classList.remove('btn-update-event');
      btnSubmit.classList.add('btn-add-event');
      btnDeleteEvent.classList.add('d-none');
      appCalendarSidebar.classList.remove('show');
      appOverlay.classList.remove('show');
    });

    // Calender filter functionality
    // ------------------------------------------------
    if (selectAll) {
      selectAll.addEventListener('click', e => {
        if (e.currentTarget.checked) {
          document.querySelectorAll('.input-filter').forEach(c => (c.checked = 1));
        } else {
          document.querySelectorAll('.input-filter').forEach(c => (c.checked = 0));
        }
        calendar.refetchEvents();
      });
    }

    if (filterInput) {
      filterInput.forEach(item => {
        item.addEventListener('click', () => {
          document.querySelectorAll('.input-filter:checked').length < document.querySelectorAll('.input-filter').length
            ? (selectAll.checked = false)
            : (selectAll.checked = true);
          calendar.refetchEvents();
        });
      });
    }

    // Jump to date on sidebar(inline) calendar change
    inlineCalInstance.config.onChange.push(function (date) {
      calendar.changeView(calendar.view.type, moment(date[0]).format('YYYY-MM-DD'));
      modifyToggler();
      appCalendarSidebar.classList.remove('show');
      appOverlay.classList.remove('show');
    });
  })();
});
