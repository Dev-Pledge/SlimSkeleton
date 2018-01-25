<?php

namespace DevPledge\Application\Repository\Organisation;


use TomWright\Database\ExtendedPDO\ExtendedPDO;
use DevPledge\Domain\Organisation;

class OrganisationMySQLRepository implements OrganisationRepository
{

    /**
     * @var ExtendedPDO
     */
    private $db;

    /**
     * OrganisationMySQLRepository constructor.
     * @param ExtendedPDO $db
     */
    public function __construct(ExtendedPDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param int $id
     * @return Organisation
     */
    public function getOrganisation(int $id): Organisation
    {
        // TODO: Implement getOrganisation() method.
    }

    /**
     * @param array $filters
     * @return Organisation[]
     */
    public function searchOrganisations(array $filters): array
    {
        // TODO: Implement searchOrganisations() method.
    }

    /**
     * @param Organisation $organisation
     * @return Organisation
     */
    public function saveOrganisation(Organisation $organisation): Organisation
    {
        // TODO: Implement saveOrganisation() method.
    }
}