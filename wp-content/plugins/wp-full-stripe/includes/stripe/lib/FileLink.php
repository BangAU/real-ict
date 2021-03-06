<?php

namespace StripeWPFS;

/**
 * Class FileLink
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property bool $expired Whether this link is already expired.
 * @property int|null $expires_at Time at which the link expires.
 * @property string|\StripeWPFS\File $file The file object this link points to.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property \StripeWPFS\StripeObject $metadata Set of key-value pairs that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property string|null $url The publicly accessible URL to download the file.
 *
 * @package StripeWPFS
 */
class FileLink extends ApiResource
{
    const OBJECT_NAME = 'file_link';

    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
}
