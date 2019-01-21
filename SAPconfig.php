<?php
namespace SAP;
use SAPNWRFC\Connection;

/**
 * Class SAPconfig
 *
 * Configuration of the SAP library
 *
 * @package SAP
 */
class SAPconfig
{
    public static $host = "";
    public static $systemnr = "XX";
    public static $client = "XXX";
    public static $username = "XXXX";
    public static $password = "XXXX";
    public static $trace = Connection::TRACE_LEVEL_FULL;
}