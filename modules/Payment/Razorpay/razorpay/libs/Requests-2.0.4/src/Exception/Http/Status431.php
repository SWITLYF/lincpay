<?php
/**
 * Exception for 431 Request Header Fields Too Large responses
 *
 * @link https://tools.ietf.org/html/rfc6585
 */

namespace WpOrg\Requests\Exception\Http;

use WpOrg\Requests\Exception\Http;

/**
 * Exception for 431 Request Header Fields Too Large responses
 *
 * @link https://tools.ietf.org/html/rfc6585
 */
final class Status431 extends Http
{
    /**
     * HTTP status code
     *
     * @var int
     */
    protected $code = 431;

    /**
     * Reason phrase
     *
     * @var string
     */
    protected $reason = 'Request Header Fields Too Large';
}
