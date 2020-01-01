<?php

namespace Drupal\remaining_time\Service;

use Drupal\Core\Datetime\DrupalDateTime;

class RemainingTimeService {

  const DATE_FORMAT = 'd-m-Y H:i:s';
  public function eventStatus($eventDate) {

   date_default_timezone_set('Europe/Ljubljana');
    $startDate = new DrupalDateTime($eventDate);
    $now = new DrupalDateTime();
    $eventStartTime = strtotime($startDate->format(self::DATE_FORMAT));
    $currentTime = strtotime($now->format(self::DATE_FORMAT));
    $lenght = 3600;
    $razlika = floor(($eventStartTime - $currentTime));
    $days = floor(($eventStartTime - $currentTime) /86400);
    $hours = floor(($eventStartTime - $currentTime) %86400/3600);
    $minutes = floor(($eventStartTime - $currentTime) %3600/60);
    $seconds = floor(($eventStartTime - $currentTime) %60);
    if (!empty($eventDate)) {
      switch (true) {
        case ( $currentTime < $eventStartTime ):
          $result = $days.(' days, ').$hours.(' hours ').$minutes.(' minutes ').$seconds.(' seconds left until event starts.');
          break;
        case ( ($currentTime >= $eventStartTime) && ($currentTime <= ($eventStartTime + $lenght))):
        
          $result = ('This event is happening right now!');
          break;

        case ( $currentTime > ($eventStartTime + $lenght)):
          $result = ('This event already passed.');
          break;
        default:
      }
      return $result;
    }

  }
}