<?php

namespace App\Controllers;

use App\Models\EventsDateModel;
use App\Models\EventsModel;

class Event extends BaseController
{
    protected EventsModel $event;
    private EventsDateModel $eventDate;

    public function __construct()
    {
        $this->event = new EventsModel();
        $this->eventDate = new EventsDateModel();
    }

    public function saveEvent()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back();
        }

        $input = $this->request->getVar();

        $data = [
            'title' => $input['title'],
            'color' => $input['color'],
            'background' => $input['bg'],
            'user_id' => $input['user_id'],
        ];

        $this->event->insert($data);

        return $this->response->setJSON([]);
    }

    public function deleteEvent()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back();
        }

        $id = $this->request->getVar('id');

        $this->event->delete($id);

        $this->eventDate->where('event_id', $id);
        $this->eventDate->delete();

        return $this->response->setJSON([]);
    }

    public function saveEventDate()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back();
        }

        $input = $this->request->getVar();

        $data = [
            'start' => $input['start'],
            'end' => date('Y-m-d', strtotime($input['start'] . ' + 1 days')),
            'user_id' => $input['user_id'],
            'event_id' => $input['event_id']
        ];

        $this->eventDate->insert($data);

        return $this->response->setJSON([]);
    }

    public function updateEventDate()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back();
        }

        $input = $this->request->getVar();;

        $this->eventDate->update(['id' => $input['id']], [
            'start' => $input['start'],
            'end' => date('Y-m-d', strtotime($input['start'] . ' + 1 days'))
        ]);

        return $this->response->setJSON([]);
    }

    public function deleteEventDate()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back();
        }

        $id = $this->request->getVar('id');

        $this->eventDate->delete($id);

        return $this->response->setJSON([]);
    }
}
