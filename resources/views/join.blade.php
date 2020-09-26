<?php 
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\JoinMeetingParameters;
$meetingID='aB1';
$meetingName='Xampp-Meeting';
$attendee_password='1234';
$moderator_password='4321';
$name="sam";
$bbb = new BigBlueButton();

// $moderator_password for moderator
$joinMeetingParams = new JoinMeetingParameters($meetingID, $name, $attendee_password);
$joinMeetingParams->setRedirect(true);
$url = $bbb->getJoinMeetingURL($joinMeetingParams);
header('Location: '.$url);
exit;
?>
