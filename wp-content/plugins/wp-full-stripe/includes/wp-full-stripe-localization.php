<?php

/**
 * Created by PhpStorm.
 * User: codex
 * Date: 2020.05.15.
 * Time: 17:15
 */
class MM_WPFS_Localization {

	public static function echoTranslatedLabel( $label ) {
		echo MM_WPFS_Localization::translateLabel( $label );
	}

	public static function translateLabel( $label, $domain = 'wp-full-stripe' ) {
		if ( empty( $label ) ) {
			return '';
		}

		return esc_attr( __( $label, $domain ) );
	}

	public static function formatIntervalLabel( $interval, $intervalCount ) {
		// This is an internal value, no need to localize it
		// todo: Instead of returning it, throw an exception
		$intervalLabel = 'No interval';

		if ( $interval === "year" ) {
			$intervalLabel = sprintf( _n( 'year', '%d years', $intervalCount, 'wp-full-stripe' ), number_format_i18n( $intervalCount ) );
		} elseif ( $interval === "month" ) {
			$intervalLabel = sprintf( _n( 'month', '%d months', $intervalCount, 'wp-full-stripe' ), number_format_i18n( $intervalCount ) );
		} elseif ( $interval === "week" ) {
			$intervalLabel = sprintf( _n( 'week', '%d weeks', $intervalCount, 'wp-full-stripe' ), number_format_i18n( $intervalCount ) );
		} elseif ( $interval === "day" ) {
			$intervalLabel = sprintf( _n( 'day', '%d days', $intervalCount, 'wp-full-stripe' ), number_format_i18n( $intervalCount ) );
		}

		return $intervalLabel;
	}

	/**
	 * @param $interval
	 * @param $intervalCount
	 * @param $formattedAmount
	 *
	 * @return string
	 * @throws Exception
	 */
	public static function getPriceAndIntervalLabel( $interval, $intervalCount, $formattedAmount ) {
		switch ( $interval ) {
			case 'day':
                /* translators: Recurring pricing descriptor.
                 * p1: formatted recurring amount with currency symbol
                 * p2: interval count
                 */
				$formatStr = _n(
					'%1$s / day',
					'%1$s / %2$d days',
					$intervalCount, 'wp-full-stripe'
				);
				break;

			case 'week':
                /* translators: Recurring pricing descriptor.
                 * p1: formatted recurring amount with currency symbol
                 * p2: interval count
                 */
				$formatStr = _n(
					'%1$s / week',
					'%1$s / %2$d weeks',
					$intervalCount, 'wp-full-stripe'
				);
				break;

			case 'month':
                /* translators: Recurring pricing descriptor.
                 * p1: formatted recurring amount with currency symbol
                 * p2: interval count
                 */
				$formatStr = _n(
					'%1$s / month',
					'%1$s / %2$d months',
					$intervalCount, 'wp-full-stripe'
				);
				break;

			case 'year':
                /* translators: Recurring pricing descriptor.
                 * p1: formatted recurring amount with currency symbol
                 * p2: interval count
                 */
				$formatStr = _n(
					'%1$s / year',
					'%1$s / %2$d years',
					$intervalCount, 'wp-full-stripe'
				);
				break;

			default:
				throw new Exception( sprintf( '%s.%s(): Unknown plan interval \'%s\'.', __CLASS__, __FUNCTION__, $interval ) );
				break;
		}

		if ( $intervalCount == 1 ) {
			$priceLabel = sprintf( $formatStr, $formattedAmount );
		} else {
			$priceLabel = sprintf( $formatStr, $formattedAmount, $intervalCount );
		}

		return $priceLabel;
	}
}