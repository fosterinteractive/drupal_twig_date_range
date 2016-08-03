<?php

namespace Drupal\twig_custom_date_range_filter\Twig;

class TwigCustomDateRangeFilter extends \Twig_Extension {

/**
* This string must be unique but there's no special rules on it.
*
* The recommended approach is just returning the magic constant __CLASS__
* since it will always be unique to the class (it contains the fully
* qualified name of the class which will include the namespace).
*/
public function getName() {
  return 'twig_custom_date_range_filter.twig.TwigCustomDateRangeFilter';
}

/**
* List of all Twig functions
*/
public function getFilters() {
  return [
  new \Twig_SimpleFilter('date_range', array($this, 'formatDateRange')),
  ];
}


/**
*  Render a custom date range format with Twig
*/

public static function formatDateRange($from_date, $to_date = NULL) {

  // If Y-m-d format convert string to timestamp
  if ($from_date_format = \DateTime::createFromFormat('Y-m-d', $from_date)) {
    $from_timestamp = strtotime($from_date);

  // If it's a dateTime object convert to timestamp
  } elseif (is_a($from_date, 'Drupal\Core\Datetime\DrupalDateTime') || is_a($from_date, 'DateTime')) {
    $from_timestamp = $from_date->getTimestamp();

  // Assumed to be a timestamp
  } else {
    $from_timestamp = $from_date;
  }

  // $to_date is optional
  if ($to_date) {

    // If Y-m-d format convert string to timestamp
    if ($to_date_format = \DateTime::createFromFormat('Y-m-d', $to_date)) {
      $to_timestamp = strtotime($to_date);

    // If it's a dateTime object convert to timestamp
    } elseif (is_a($to_date, 'Drupal\Core\Datetime\DrupalDateTime') || is_a($to_date, 'DateTime')){
      $to_timestamp = $to_date->getTimestamp();

    // Assumed to be a timestamp
    } else{
      $to_timestamp = $to_date;
    }

    // Check if $from_date & $to_date are not in same year
    $same_year = date('Y', $from_timestamp) == date('Y', $to_timestamp);
    // Check if $from_date & $to_date are not in same month
    $same_month = date('m', $from_timestamp) == date('m', $to_timestamp);

    // Long format output for dates in different years
    // EG. Jun 15, 2016 - Feb 6, 2017
    if (!$same_year) {
      return date('M j, Y', $from_timestamp) .' - ' . date('M j, Y', $to_timestamp);
    }

    // Medium output
    // EG. Jun 15 - Feb 6, 2017
    elseif ($same_year && !$same_month) {
      return date('M d', $from_timestamp) .' - ' . date('M j, Y', $to_timestamp);
    // Assume Month & Year are the same

    // Short Output
    // Jun 15-17, 2017
    } else {
      return date('M j', $from_timestamp) .'-' . date('j, Y', $to_timestamp);
    }

  }

  // If no $to_date defined in twig filter, return $from_date in default format
  // EG Jun 15, 2017
  return(date('M j, Y', $from_timestamp));


  }
}
