<?php
use Illuminate\Support\Facades\Session;

if (!function_exists('getUserLogin')) {
    function getUserLogin()
    {
        $employeeId = Session::get('user');
        $employee = \App\Model\Employee::query()->find($employeeId);
        return $employee;
    }
}

if(!function_exists('getValueConstant'))
{
    function getValueConstant($name, $key)
    {
        return config('constant.'.$name)[$key];
    }
}

if(!function_exists('isAdmin'))
{
    function isAdmin()
    {
        $user = getUserLogin();
        if ($user['employee_account'] == config('constant.ADMIN'))
            return true;
        return false;
    }
}

if(!function_exists('formatCurrency'))
{
    function formatCurrency($price)
    {
        return number_format($price, 0, '', '.');
    }
}

?>