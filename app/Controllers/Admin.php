<?php

namespace App\Controllers;

use App\Models\DistributionModel;
use App\Models\EmployeeModel;
use App\Models\MenuModel;
use App\Models\CategoryModel;
use App\Models\EventsModel;
use App\Models\EventsDateModel;
use App\Models\KaryawanModel;
use App\Models\TransaksiModel;

class Admin extends BaseController
{
    private MenuModel $menu;
    private CategoryModel $category;
    private EventsModel $events;
    private EventsDateModel $date;
    private EmployeeModel $employee;
    private DistributionModel $distribution;

    public function __construct()
    {
        $this->menu = new MenuModel();
        $this->category = new CategoryModel();
        $this->events = new EventsModel();
        $this->date = new EventsDateModel();
        $this->employee = new EmployeeModel();
        $this->distribution = new DistributionModel();
    }

    public function index(): string
    {
        $menu = $this->menu->findAll();
        $category = $this->category->findAll();
        $employee = $this->employee->findAll();
        $distribution = $this->distribution->findAll();
        $events = $this->events->getEvents(user()->id);
        $eventDate = $this->date->getEventDate(user()->id);

        $data = [
            'title' => 'Admin',
            'menu' => $menu,
            'category' => $category,
            'employee' => $employee,
            'distribution' => $distribution,
            'events' => $events,
            'eventDate' => $eventDate,
        ];

        return view('admin/index', $data);
    }
}
