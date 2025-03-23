<?php
/**
 * An interface that provides the API for all data providers.
 *
 * @since 1.0.0
 *
 * @package TEC\Common\StellarWP\Telemetry\Contracts
 */

namespace TEC\Common\StellarWP\Telemetry\Contracts;

/**
 * An interface that provides the API for all data providers.
 *
 * @since 1.0.0
 *
 * @package TEC\Common\StellarWP\Telemetry\Contracts
 */
interface Data_Provider {

	/**
	 * Gets the data that should be sent to the telemetry server.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_data(): array;
}
