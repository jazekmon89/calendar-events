<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Add an Event</div>
                    <div class="card-body">
                      <form id="event-form">
                        <div class="form-group">
                          <label for="event_name">Name</label>
                          <input type="text" class="form-control" :class="{ error: event_name_error }" id="event_name" name="event_name" aria-describedby="eventNameHelp" placeholder="Enter event name" v-model="event_name">
                          <small id="eventNameHelp" class="form-text text-muted" :class="{ error: event_name_error }">Enter a name for your event.</small>
                        </div>
                        <div class="form-group">
                          <label for="date_range">Date range</label>
                          <input type="text" class="form-control" id="date_range" name="date_range" aria-describedby="dateRangeHelp" placeholder="Choose a date range">
                          <small id="dateRangeHelp" class="form-text text-muted">Choose a start and end date.</small>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-4">Days</div>
                          <div class="col-sm-8">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="day1" value="1" v-model="event_days">
                              <label class="form-check-label" for="day1">
                                Monday
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="day2" value="2" v-model="event_days">
                              <label class="form-check-label" for="day2">
                                Tuesday
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="day3" value="3" v-model="event_days">
                              <label class="form-check-label" for="day3">
                                Wednesday
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="day4" value="4" v-model="event_days">
                              <label class="form-check-label" for="day4">
                                Thursday
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="day5" value="5" v-model="event_days">
                              <label class="form-check-label" for="day5">
                                Friday
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="day6" value="6" v-model="event_days">
                              <label class="form-check-label" for="day6">
                                Saturday
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="day7" value="0" v-model="event_days">
                              <label class="form-check-label" for="day7">
                                Sunday
                              </label>
                            </div>
                          </div>
                          <div class="form-group">
                            <small class="col-sm-12 form-text text-muted" :class="{ error: event_days_error }">Choose the recurring event days.</small>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-12 text-right">
                            <button type="button" v-on:click="beforeSubmit(calendar)" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Calendar</div>
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  data: () => ({
    calendar: null,
    event_name: '',
    event_name_error: false,
    event_days: [],
    event_days_error: false,
    event_date_range: {},
    events: []
  }),
  created: function () {
    this.getEvents();
  },
  methods: {
    getEvents: function() {
      axios.get('api/calendar-events')
      .then(response => {
        if (typeof response !== 'undefined') {
          this.generateEvents(response.data.event_name, response.data.event_days, response.data.start_date, response.data.end_date);;
          this.initCalendar();
        }
      })
      .catch(err => {
        // error has been handled.
      })
    },
    initCalendar: function() {
      let that = this;
      let calendarEl = document.getElementById('calendar')
      this.calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid' ],
        header: {
          left: 'prevYear,prev,next,nextYear today',
          center: 'title',
          right: 'dayGridMonth,dayGridWeek,dayGridDay'
        },
        defaultDate: moment().format("YYYY-MM-DD"),
        navLinks: true,
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: this.events
      });
      this.calendar.render()
      $('#date_range').daterangepicker({
        opens: 'left',
        autoUpdateInput: true,
      }, function(start, end, label) {
        //$('#date_range').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'))
        that.event_date_range = { start_date: start.format('YYYY-MM-DD'), end_date: end.format('YYYY-MM-DD')};
      });
      /*$('#daterange').on('apply.daterangepicker', function(ev, picker) {
        $('#date_range').val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'))
        that.selected_date_range = { start: picker.startDate.format('YYYY-MM-DD'), end: picker.endDate.format('YYYY-MM-DD')}
      });
      $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('')
      });*/
    },
    generateEvents: function(event_name, event_days, start_date, end_date) {
      //creating JS date objects
      let start = new Date(start_date)
      let end = new Date(end_date)
      let date_stack = []
      let temp_event_days = event_days//this.event_days
      this.events = [];
      if (this.event_days.length == 7) {
        this.events.push({
          title: event_name,
          start: start_date,
          end: end_date + 'T23:59:59'
        })
      } else {
        //Logic for getting rest of the dates between two dates("FromDate" to "EndDate")
        while(start <= end){
          if (temp_event_days.includes(moment(start).day().toString())) {
            date_stack.push(moment(start).format('YYYY-MM-DD'));
          } else {
            if (!_.isEmpty(date_stack)) {
              this.events.push({
                title: event_name,
                start: date_stack[0],
                end: date_stack[date_stack.length-1] + 'T23:59:59'
              })
              date_stack = []
            }
            temp_event_days = event_days
          }
          var newDate = start.setDate(start.getDate() + 1)
          start = new Date(newDate)
        }
        if (!_.isEmpty(date_stack)) {
          this.events.push({
            title: event_name,
            start: date_stack[0],
            end: date_stack[date_stack.length-1] + 'T23:59:59'
          })
          date_stack = []
        }
      }
    },
    reInitCalendar: function() {
      this.generateEvents(this.event_name, this.event_days, this.event_date_range.start_date, this.event_date_range.end_date);
      this.calendar.removeAllEvents()
      this.calendar.addEventSource(this.events)
    },
    beforeSubmit: function(calendar) {
      let that = this;
      if (this.event_name.length == 0) {
        this.event_name_error = true
      } else {
        this.event_name_error = false
      }
      if (_.isEmpty(this.event_days)) {
        this.event_days_error = true
      } else {
        if (_.difference(this.event_days, ['0','1','2','3','4','5','6']).length !== 0) {
          this.event_days_error = true
        } else {
          this.event_days_error = false
        }
      }
      if (_.isEmpty(this.event_date_range) && $('#date_range').data('daterangepicker').startDate && $('#date_range').data('daterangepicker').endDate) {
        this.event_date_range = {
          start_date: $('#date_range').data('daterangepicker').startDate.format('YYYY-MM-DD'),
          end_date: $('#date_range').data('daterangepicker').endDate.format('YYYY-MM-DD')
        }
      }
      if (!this.event_name_error && !this.event_days_error) {
        this.saveEvents({
          event_name: that.event_name,
          event_date_range: that.event_date_range,
          event_days: that.event_days
        });
      }
    },
    saveEvents: function(data) {
      axios.post('api/calendar-events', data)
      .then(response => {
        if (typeof response !== 'undefined') {
          this.$root.handleSuccess("Event successfully saved.")
          this.reInitCalendar()
        }
      })
      .catch(err => {
        // error has been handled.
      })
    }
  }
}
</script>