<?php

/**
 * @SWG\GET(
 *     path="/getCurrentTopMediasByLocationId.php",
 *     tags={"Account"},
 *     summary="",
 *     description="",
 *     @SWG\Parameter(
 *         name="username",
 *         in="query",
 *         description="username",
 *         required=true,
 *         type="string",
 *     ),
 *     @SWG\Parameter(
 *         name="password",
 *         in="query",
 *         description="password",
 *         required=true,
 *         type="string",
 *     ),
 *     @SWG\Parameter(
 *         name="locationId",
 *         in="query",
 *         description="locationId",
 *         required=true,
 *         type="integer",
 *     ),
 *     @SWG\Parameter(
 *         name="count",
 *         in="query",
 *         description="count",
 *         required=true,
 *         type="integer",
 *     )
 * )
 */


require __DIR__ . '/../vendor/autoload.php';

$username = $_GET['username'];
$password = $_GET['password'];
$locationId = $_GET['locationId'];
$count = $_GET['count'];

$instagram = \InstagramScraper\Instagram::withCredentials($username, $password, '');
$instagram->login();


$medias = $instagram->getMediasByLocationId($locationId, $count);

$data = array();

foreach ($medias as $media) {
    $account = $media->getOwner();
    $result = array(
        $accountInfo = array(
            "Id" => $account->getId(),
            "Username" => $account->getUsername(),
            "Full name" => $account->getFullName(),
            "Profile pic url" => $account->getProfilePicUrl()
        ),
        "Id" => $media->getId(),
        "Shotrcode" => $media->getShortCode(),
        "Created" => $media->getCreatedTime(),
        "Caption" => $media->getCaption(),
        "Number of comments" => $media->getCommentsCount(),
        "Number of likes" => $media->getLikesCount(),
        "Get link:" => $media->getLink(),
        "High resolution image" => $media->getImageHighResolutionUrl(),
        "Media type (video or image)" => $media->getType(),
        "Timestamp" => $media->getCreatedTime()
    );
    array_push($data, $result);
}

echo json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

//$media = $medias[0];
//echo "Media info:\n";
//echo "Id: {$media->getId()}\n";
//echo "Shotrcode: {$media->getShortCode()}\n";
//echo "Created at: {$media->getCreatedTime()}\n";
//echo "Caption: {$media->getCaption()}\n";
//echo "Number of comments: {$media->getCommentsCount()}";
//echo "Number of likes: {$media->getLikesCount()}";
//echo "Get link: {$media->getLink()}";
//echo "High resolution image: {$media->getImageHighResolutionUrl()}";
//echo "Media type (video or image): {$media->getType()}";
//$account = $media->getOwner();
//echo "Account info:\n";
//echo "Id: {$account->getId()}\n";
//echo "Username: {$account->getUsername()}\n";
//echo "Full name: {$account->getFullName()}\n";
//echo "Profile pic url: {$account->getProfilePicUrl()}\n";
