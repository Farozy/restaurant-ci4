<div class="row">
    <div class="col-md-3">
        <div class="sticky-top mb-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Daftar Events</h4>
                </div>
                <div class="card-body">
                    <div id="external-events">
                        <?php if (!empty($events)) : ?>
                            <?php foreach ($events as $x => $row) : ?>
                                <div class="external-event bg-<?= $row['color'] ?> text-light "
                                     title="Drag & Drop Event" id="<?= $row['id'] ?>">
                                    <input type="hidden">
                                    <button type="button" data-toggle="tooltip" title="Hapus Event"
                                            onclick="deleteEvent(<?= $row['id'] ?>)"
                                            style="border: none;background: none;cursor: pointer;margin: 0;padding: 0;color: #f8f9fc; "
                                            onmouseover="this.style.textDecoration='underline'"
                                            onmouseout="this.style.textDecoration='none'">
                                        <?= $row['title'] ?>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="text-center font-weight-bold text-muted notEvents">Belum ada event</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Create Event</h3>
                </div>
                <div class="card-body">
                    <div class="btn-group list-group" style="margin-bottom: 10px;">
                        <ul class="fc-color-picker mx-auto" id="color-chooser">
                            <li>
                                <a class="text-primary" data="#4e73df" href="#"><i class="fas fa-square"></i></a>
                            <li>
                                <a class="text-info" data="#36b9cc" href="#"><i class="fas fa-square"></i></a>
                            </li>
                            <li>
                                <a class="text-success" data="#1cc88a" href="#"><i class="fas fa-square"></i></a>
                            </li>
                            <li>
                                <a class="text-danger" data="#e74a3b" href="#"><i class="fas fa-square"></i></a>
                            </li>
                            <li>
                                <a class="text-warning" data="#f6c23e" href="#"><i class="fas fa-square"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="input-group">
                        <input id="new-event" type="text" class="form-control form-control-sm"
                               placeholder="Event Title">

                        <div class="input-group-append">
                            <button id="add-new-event" type="button" class="btn btn-primary btn-sm" disabled>
                                <i class="fas fa-plus font-weight-bold"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card card-primary">
            <div class="card-body p-3">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.fc-col-header ').css('border', '5px solid #fff');

        ini_events($('#external-events div.external-event'))

        const Calendar = FullCalendar.Calendar;
        const Draggable = FullCalendar.Draggable;

        const containerEl = document.getElementById('external-events');
        // const checkbox = document.getElementById('drop-remove');
        const calendarEl = document.getElementById('calendar');

        new Draggable(containerEl, {
            itemSelector: '.external-event',
            eventData: function (eventEl) {
                return {
                    title: eventEl.innerText,
                    backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
                };
            }
        });

        const calendar = new Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            titleFormat: {
                year: 'numeric',
                month: 'long',
                // day: 'numeric'
            },
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari',
            },
            // themeSystem: 'bootstrap5',
            events: [
                <?php foreach ($eventDate as $row) : ?> {
                    <?php $month = date('m', strtotime($row->start)) - 1; ?>
                    id: <?= $row->id_date  ?>,
                    title: `<?= $row->title ?>`,
                    start: new Date(<?= date('Y', strtotime($row->start)) ?>, <?= $month; ?>, <?= date('d', strtotime($row->start)) ?>),
                    backgroundColor: `<?= $row->background ?>`,
                    borderColor: '<?= $row->background ?>',
                    allDay: true
                },
                <?php endforeach; ?>
            ],
            editable: true,
            droppable: true,
            drop: function (info) {
                handleDrop(info)
            },
            eventDrop: function (info) {
                eventDrop(info)
            },
            eventClick: function (info) {
                eventClick(info)
            },
            eventMouseEnter: function () {
                $(".fc-daygrid-day-events").prop('title', "Update and Delete Event")
            },
            eventMouseLeave: function () {
                $(".fc-daygrid-day-events").prop('title', "")
            }
        });

        calendar.render();
        calendar.setOption('locale', 'id');

        let currColor = '#3c8dbc'
        let bg = '#4e73df';
        let color = 'primary';
        let title = '';
        const user_id = <?= user()->id ?>;

        $('#color-chooser > li > a').click(function (e) {
            e.preventDefault()
            // Save color
            currColor = $(this).css('color')
            let text = $(this).attr('class');
            color = text.replace('text-', '');
            bg = $(this).attr('data');

            $('#add-new-event').css({
                'background-color': currColor,
                'border-color': currColor
            })
        })

        $('#new-event').keyup(function () {
            title = $(this).val();

            if (title !== '') {
                $('#add-new-event').prop('disabled', false);
            } else {
                $('#add-new-event').prop('disabled', true);
            }
        })

        $('#add-new-event').click(function (e) {
            e.preventDefault()
            $('.notEvents').remove();
            addNewEvent(title, color, bg, user_id)
        })
    })

    function addNewEvent(title, color, bg, user_id) {
        setAjax('<?= route_to('saveEvent') ?>', 'post', {
            title,
            color,
            bg,
            user_id
        }, function () {
            simpleSweetAlert('success', 'Event berhasil disimpan').then(() => {
                location.reload()
            })
        })

        $('#new-event').val('')
        $('#add-new-event').prop('disabled', true);
    }

    function eventClick(info) {
        questionSweetAlert('Yakin?', 'Event akan dihapus', 'warning').then((result) => {
            if (result.isConfirmed) {
                setAjax('<?= route_to('deleteEventDate') ?>', 'post', {id: info.event.id}, function () {
                    simpleSweetAlert('success', 'Event berhasil dihapus').then(() => {
                        location.reload();
                    })
                })
            }
        })
    }

    function handleDrop(info) {
        let events_id = parseInt(info.draggedEl.id);
        let start = info.dateStr;

        setAjax('<?= route_to('saveEventDate') ?>', 'post', {
            user_id: <?= user()->id ?>,
            event_id: events_id,
            start: start
        }, function () {
            simpleSweetAlert('success', 'Event berhasil ditambahkan').then(() => {
                location.reload();
            })
        })
        // if (checkbox.checked) {
        //     info.draggedEl.parentNode.removeChild(info.draggedEl);
        // }
    }

    function eventDrop(info) {
        const id = parseInt(info.event.id)
        let date = new Date(info.event.start);
        let d = date.getDate();
        let m = date.getMonth() + 1;
        let y = date.getFullYear();

        setAjax('<?= route_to('updateEventDate') ?>', 'post', {
            id,
            start: y + '-' + m + '-' + d
        }, function () {
            simpleSweetAlert('success', 'Event berhasil diupdate').then(() => {
                location.reload();
            })
        })
    }

    function ini_events(event) {
        event.each(function () {
            const eventObject = {
                title: $.trim($(this).text())
            }

            $(this).data('eventObject', eventObject)
        })
    }

    function deleteEvent(id) {
        setAjax('<?= route_to('deleteEvent') ?>', 'post', {id}, function () {
            simpleSweetAlert('success', 'Event berhasil dihapus').then(() => {
                location.reload()
            })
        })
    }
</script>