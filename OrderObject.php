<?php


namespace SAP;


class OrderObject
{
    const HEADER = "HEADER";
    const POSITIONS = "POSITIONS";
    const SEQUENCES = "SEQUENCES";
    const PHASES = "PHASES";
    const COMPONENTS = "COMPONENTS";
    const PROD_REL_TOOLS = "PROD_REL_TOOLS";
    const TRIGGER_POINTS = "TRIGGER_POINTS";
    const SECONDARY_RESOURCES = "SECONDARY_RESOURCES";

    private $list = array();

    /**
     * Add to order Objects
     * @param String $object
     * @return $this OrderObject
     */
    public function add(String $object)
    {
        $this->list[$object] = "X";

        return $this;
    }

    /**
     * Get list of OrderObjects
     * @return array
     */
    public function get()
    {
        return $this->list;
    }
}