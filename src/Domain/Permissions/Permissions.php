<?php


namespace DevPledge\Domain\Permissions;


use JsonSerializable;

class Permissions implements JsonSerializable
{

    /**
     * @var Resource[]
     */
    private $resources;

    /**
     * Permissions constructor.
     */
    public function __construct()
    {
        $this->resources = [];
    }

    /**
     * @param Resource[] $resources
     * @return Permissions
     */
    public function setResources(array $resources): Permissions
    {
        $this->resources = $resources;
        return $this;
    }

    /**
     * @param Resource $resource
     * @return Permissions
     */
    public function addResource(Resource $resource): Permissions
    {
        $this->resources[] = $resource;
        return $this;
    }

    /**
     * @return Resource[]
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $result = [];
        foreach ($this->resources as $r) {
            $result[$r->getName()] = $r;
        }
        return $result;
    }
}