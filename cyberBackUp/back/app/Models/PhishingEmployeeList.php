<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhishingEmployeeList extends Model
{

    use HasFactory;
    protected $table = 'phishing_campaign_employee_list'; // Specify the table name

}
