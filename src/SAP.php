<?php
namespace SAP;

use SAPNWRFC\Connection;

/**
 * Class SAP
 * @package SAP
 */
class SAP
{
    const HEADER = "HEADER";
    const POSITIONS = "POSITIONS";
    const SEQUENCES = "SEQUENCES";
    const PHASES = "PHASES";
    const COMPONENTS = "COMPONENTS";
    const PROD_REL_TOOLS = "PROD_REL_TOOLS";
    const TRIGGER_POINTS = "TRIGGER_POINTS";
    const SECONDARY_RESOURCES = "SECONDARY_RESOURCES";

    /**
     * @var Connection SAPconnection
     */
    private $connection;

    /**
     * SAP constructor.
     * @param string $host SAP Host
     * @param string $sysnr System number
     * @param string $client Client number
     * @param string $user username
     * @param string $password password
     * @param bool $debug
     */
    public function __construct(string $host, string $sysnr, string $client, string $user, string $password, bool $debug = false)
    {
        $config = array(
            "ashost" => $host,
            "sysnr" => $sysnr,
            "client" => $client,
            "user" => $user,
            "passwd" => $password
        );

        if($debug) {
            $config["trace"] = Connection::TRACE_LEVEL_FULL;
        }

        $this->connection = new Connection($config);
    }

    /**
     * @param $table string
     * @param $fields array fields
     * @param $options string WHERE options
     * @param $rows int Amount of rows to return
     * @return array Data
     */
    public function RFC_READ_TABLE(string $table, array $fields, string $options, int $rows) : array
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
     * @return array
     */
    public function PRODUCTION_ORDER_READ(int $order)
    {
        $param = array();

        $function = $this->connection->getFunction("BAPI_PROCORD_GET_DETAIL");

        $function->setParameterActive("NUMBER", true);
        $function->setParameterActive("ORDER_OBJECTS", true);
        //order number needs be 12 chars long so we need to fill up with zero's
        $param["NUMBER"] = str_pad($order, 12, "0", STR_PAD_LEFT);
        $param["ORDER_OBJECTS"] =
            array(
                "HEADER" => "X",
                "POSITIONS" => "X",
                "SEQUENCES" => "X",
                "PHASES" => "X",
                "COMPONENTS" => "X",
                "PROD_REL_TOOLS" => "X",
                "TRIGGER_POINTS" => "X",
                "SECONDARY_RESOURCES" => "X"
            );

        return $function->invoke($param);
    }

    /**
     * Print a certain HU Label
     * @param string $handlingunit HU number
     * @param string $output OutputDevice
     * @return array
     */
    public function HU_PRINT(string $handlingunit, string $output) : array
    {
        $param = array();
        $function = $this->connection->getFunction("BAPI_HU_PROCESS_MSG_DIRECT");
        $function->setParameterActive("DYNAMICOUTPUTDEVICE", true);
        $function->setParameterActive("HUKEY", true);
        $param["DYNAMICOUTPUTDEVICE"] = array("OUTPUT_DEVICE" => $output);
        $param["HUKEY"] = array(array("HU_EXID" => str_pad($handlingunit, 20, "0", STR_PAD_LEFT)));

        return $function->invoke($param);
    }
}