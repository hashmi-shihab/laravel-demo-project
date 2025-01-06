<?php

use App\Models\API\Carrier;
use App\Models\API\CarrierType;
use App\Models\API\Customer;
use App\Models\API\NotificationHistory;
use App\Models\API\Provider;
use App\Models\API\RouteType;
use App\Models\API\SupportTicket;
use App\Models\API\SupportTicketResponse;
use App\Models\API\SystemFirstEmailSms;
use App\Models\Payment\Invoice;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

if (!function_exists('baseUrl')) {
    function baseUrl()
    {
        return 'https://' . $_SERVER['HTTP_HOST'];
    }
}
