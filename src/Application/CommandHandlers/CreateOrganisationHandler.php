<?php

namespace DevPledge\Application\CommandHandlers;

use DevPledge\Application\Commands\CreateOrganisationCommand;
use DevPledge\Application\Services\OrganisationService;
use DevPledge\Integrations\Command\AbstractCommandHandler;

/**
 * Class CreateOrganisationHandler
 * @package DevPledge\Application\CommandHandlers
 */
class CreateOrganisationHandler extends AbstractCommandHandler {

	/**
	 * CreateOrganisation constructor.
	 *
	 * @param OrganisationService $organisationService
	 */
	public function __construct() {
		parent::__construct( CreateOrganisationCommand::class );
	}

	/**
	 * @param CreateOrganisationCommand $command
	 *
	 * @return \DevPledge\Domain\Organisation
	 */
	public function handle( $command ) {

		return OrganisationService::getService()->create( $command->getName() );
	}
}