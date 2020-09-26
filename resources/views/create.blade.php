<?php
 putenv("BBB_SERVER_BASE_URL=https://bbb.sam-ticc.com/bigbluebutton/");
 putenv("BBB_SECRET=pBFDoR5mMexbzhNdPmptyHVEwFaFlYUHx3u3fAnWfYs");
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;

$meetingID='aB1';
$meetingName='Xampp-Meeting';
$attendee_password='1234';
$moderator_password='4321';
$duration='';
$urlLogout='';
$name='SamTic';
$bbb = new BigBlueButton();

$createMeetingParams = new CreateMeetingParameters($meetingID, $meetingName);
$createMeetingParams->setAttendeePassword($attendee_password);
$createMeetingParams->setModeratorPassword($moderator_password);
// $createMeetingParams->setDuration($duration);
// $createMeetingParams->setLogoutUrl($urlLogout);
// if ($isRecordingTrue) {
// 	$createMeetingParams->setRecord(true);
// 	$createMeetingParams->setAllowStartStopRecording(true);
// 	$createMeetingParams->setAutoStartRecording(true);
// }

$response = $bbb->createMeeting($createMeetingParams);
if ($response->getReturnCode() == 'FAILED') {
	return 'Can\'t create room! please contact our administrator.';
} else {
    echo "meeting created !!";
    $joinMeetingParams = new JoinMeetingParameters($meetingID, $name, $moderator_password);
    $joinMeetingParams->setRedirect(true);
    $url = $bbb->getJoinMeetingURL($joinMeetingParams);
    header('Location: '.$url);
exit;
}
?>