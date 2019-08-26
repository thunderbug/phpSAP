<?php
namespace SAP;

use SAPNWRFC\Connection;

/**
 * Class SAP
 * @package SAP
 */
class SAP
{
    /**
     * @var Connection SAPconnection
     */
    private $connection;

    /**
     * SAP constructor.
     */
    public function __construct()
    {
        require_once ("SAPconfig.php");
        require_once ("OrderObject.php");

        $config = array(
            "ashost" => SAPconfig::$host,
            "sysnr" => SAPconfig::$systemnr,
            "client" => SAPconfig::$client,
            "user" => SAPconfig::$username,
            "passwd" => SAPconfig::$password,
            "trace" => SAPconfig::$trace
        );

        $this->connection = new Connection($config);
    }

    /**
     * @param $table string
     * @param $fields array fields
     * @param $options string WHERE options
     * @param $rows int Amount of rows to return
     * @return array Data
     */
    public function RFC_READ_TABLE(string $table, string $fields, string $options, string $rows) : array
    {
        $param = array();

        $function = $this->connection->getFunction("RFC_READ_TABLE");

        $function->setParameterActive("QUERY_TABLE", true);
        $function->setParameterActive("DELIMITER", true);
        $function->setParameterActive("NO_DATA", true);
        $function->setParameterActive("ROWCOUNT", true);
        $function->setParameterActive("OPTIONS", true);
        $function->setParameterActive("FIELDS", true);

        $param["QUERY_TABLE"] = $table;
        $param["DELIMITER"] = ";";
        $param["NO_DATA"] = "";
        $param["ROWCOUNT"] = $rows;
        $param["OPTIONS"] = array(array("TEXT" => $options));

        $paramFields = array();
        foreach ($fields as $field) {
            $paramFields[] = array("FIELDNAME" => $field);
        }
        $param["FIELDS"] = $paramFields;

        return $function->invoke($param);
    }

    /**
     * Get Details of a ProcessOrder
     * @param int $order ProcessOrder
     * @param OrderObject $object
     * @return array
     */
    public function PRODUCTION_ORDER_READ(int $order, OrderObject $object) : array
    {
        $param = array();

        $function = $this->connection->getFunction("BAPI_PROCORD_GET_DETAIL");

        $function->setParameterActive("NUMBER", true);
        $function->setParameterActive("ORDER_OBJECTS", true);

        //order number needs be 12 chars long so we need to fill up with zero's
        $param["NUMBER"] = str_pad($order, 12, "0", STR_PAD_LEFT);
        $param["ORDER_OBJECTS"] = $object->get();

        return $function->invoke($param);
    }

    /**
     * Get Details of a ProcessOrder
     * @param int $order ProcessOrder
     * @return array
     */
    public function PRODUCTION_ORDER_CHANGE(int $order) : array
    {
        $param = array();

        $function = $this->connection->getFunction("BAPI_PRODORD_CHANGE");

        $function->setParameterActive("NUMBER", true);

        //order number needs be 12 chars long so we need to fill up with zero's
        $param["NUMBER"] = str_pad($order, 12, "0", STR_PAD_LEFT);

        return $function->invoke($param);
    }

    /**
     * Print HU Label
     * @param string $output PrinterName
     * @return array
     */
    public function HU_PROCESS_MSG_DIRECT(string $output) : array
    {
        $param = array();
        $function = $this->connection->getFunction("BAPI_HU_PROCESS_MSG_DIRECT");
        $function->setParameterActive("DYNAMICOUTPUTDEVICE", true);
        $param["DYNAMICOUTPUTDEVICE"] = $output;

        return $function->invoke($param);
    }
}