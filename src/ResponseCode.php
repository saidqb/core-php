<?php

namespace Saidqb\CorePhp;


/**
 * Representation of an outgoing, server-side response.
 * Most of these methods are supplied by ResponseTrait.
 *
 * Per the HTTP specification, this interface includes properties for
 * each of the following:
 *
 * - Protocol version
 * - Status code and reason phrase
 * - Headers
 * - Message body
 */
class ResponseCode
{
    /**
     * Constants for status codes.
     * From  https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
     */
    // Informational
    public const HTTP_CONTINUE                        = 100;
    public const HTTP_SWITCHING_PROTOCOLS             = 101;
    public const HTTP_PROCESSING                      = 102;
    public const HTTP_EARLY_HINTS                     = 103;
    public const HTTP_OK                              = 200;
    public const HTTP_CREATED                         = 201;
    public const HTTP_ACCEPTED                        = 202;
    public const HTTP_NONAUTHORITATIVE_INFORMATION    = 203;
    public const HTTP_NO_CONTENT                      = 204;
    public const HTTP_RESET_CONTENT                   = 205;
    public const HTTP_PARTIAL_CONTENT                 = 206;
    public const HTTP_MULTI_STATUS                    = 207;
    public const HTTP_ALREADY_REPORTED                = 208;
    public const HTTP_IM_USED                         = 226;
    public const HTTP_MULTIPLE_CHOICES                = 300;
    public const HTTP_MOVED_PERMANENTLY               = 301;
    public const HTTP_FOUND                           = 302;
    public const HTTP_SEE_OTHER                       = 303;
    public const HTTP_NOT_MODIFIED                    = 304;
    public const HTTP_USE_PROXY                       = 305;
    public const HTTP_SWITCH_PROXY                    = 306;
    public const HTTP_TEMPORARY_REDIRECT              = 307;
    public const HTTP_PERMANENT_REDIRECT              = 308;
    public const HTTP_BAD_REQUEST                     = 400;
    public const HTTP_UNAUTHORIZED                    = 401;
    public const HTTP_PAYMENT_REQUIRED                = 402;
    public const HTTP_FORBIDDEN                       = 403;
    public const HTTP_NOT_FOUND                       = 404;
    public const HTTP_METHOD_NOT_ALLOWED              = 405;
    public const HTTP_NOT_ACCEPTABLE                  = 406;
    public const HTTP_PROXY_AUTHENTICATION_REQUIRED   = 407;
    public const HTTP_REQUEST_TIMEOUT                 = 408;
    public const HTTP_CONFLICT                        = 409;
    public const HTTP_GONE                            = 410;
    public const HTTP_LENGTH_REQUIRED                 = 411;
    public const HTTP_PRECONDITION_FAILED             = 412;
    public const HTTP_PAYLOAD_TOO_LARGE               = 413;
    public const HTTP_URI_TOO_LONG                    = 414;
    public const HTTP_UNSUPPORTED_MEDIA_TYPE          = 415;
    public const HTTP_RANGE_NOT_SATISFIABLE           = 416;
    public const HTTP_EXPECTATION_FAILED              = 417;
    public const HTTP_IM_A_TEAPOT                     = 418;
    public const HTTP_MISDIRECTED_REQUEST             = 421;
    public const HTTP_UNPROCESSABLE_ENTITY            = 422;
    public const HTTP_LOCKED                          = 423;
    public const HTTP_FAILED_DEPENDENCY               = 424;
    public const HTTP_TOO_EARLY                       = 425;
    public const HTTP_UPGRADE_REQUIRED                = 426;
    public const HTTP_PRECONDITION_REQUIRED           = 428;
    public const HTTP_TOO_MANY_REQUESTS               = 429;
    public const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    public const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS   = 451;
    public const HTTP_CLIENT_CLOSED_REQUEST           = 499;
    public const HTTP_INTERNAL_SERVER_ERROR           = 500;
    public const HTTP_NOT_IMPLEMENTED                 = 501;
    public const HTTP_BAD_GATEWAY                     = 502;
    public const HTTP_SERVICE_UNAVAILABLE             = 503;
    public const HTTP_GATEWAY_TIMEOUT                 = 504;
    public const HTTP_HTTP_VERSION_NOT_SUPPORTED      = 505;
    public const HTTP_VARIANT_ALSO_NEGOTIATES         = 506;
    public const HTTP_INSUFFICIENT_STORAGE            = 507;
    public const HTTP_LOOP_DETECTED                   = 508;
    public const HTTP_NOT_EXTENDED                    = 510;
    public const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;
    public const HTTP_NETWORK_CONNECT_TIMEOUT_ERROR   = 599;


    public const HTTP_CONTINUE_MESSAGE                        = 'Continue'; // 100
    public const HTTP_SWITCHING_PROTOCOLS_MESSAGE             = 'Switching Protocols'; // 101
    public const HTTP_PROCESSING_MESSAGE                      = 'Processing'; // 102
    public const HTTP_EARLY_HINTS_MESSAGE                     = 'Early Hints'; // 103
    public const HTTP_OK_MESSAGE                              = 'Success'; // 200
    public const HTTP_CREATED_MESSAGE                         = 'Created'; // 201
    public const HTTP_ACCEPTED_MESSAGE                        = 'Accepted'; // 202
    public const HTTP_NONAUTHORITATIVE_INFORMATION_MESSAGE    = 'Non-Authoritative Information'; // 203
    public const HTTP_NO_CONTENT_MESSAGE                      = 'No Content'; // 204
    public const HTTP_RESET_CONTENT_MESSAGE                   = 'Reset Content'; // 205
    public const HTTP_PARTIAL_CONTENT_MESSAGE                 = 'Partial Content'; // 206
    public const HTTP_MULTI_STATUS_MESSAGE                    = 'Multi-Status'; // 207
    public const HTTP_ALREADY_REPORTED_MESSAGE                = 'Already Reported'; // 208
    public const HTTP_IM_USED_MESSAGE                         = 'IM Used'; // 226
    public const HTTP_MULTIPLE_CHOICES_MESSAGE                = 'Multiple Choices'; // 300
    public const HTTP_MOVED_PERMANENTLY_MESSAGE               = 'Moved Permanently'; // 301
    public const HTTP_FOUND_MESSAGE                           = 'Found'; // 302
    public const HTTP_SEE_OTHER_MESSAGE                       = 'See Other'; // 303
    public const HTTP_NOT_MODIFIED_MESSAGE                    = 'Not Modified'; // 304
    public const HTTP_USE_PROXY_MESSAGE                       = 'Use Proxy'; // 305
    public const HTTP_SWITCH_PROXY_MESSAGE                    = 'Switch Proxy'; // 306
    public const HTTP_TEMPORARY_REDIRECT_MESSAGE              = 'Temporary Redirect'; // 307
    public const HTTP_PERMANENT_REDIRECT_MESSAGE              = 'Permanent Redirect'; // 308
    public const HTTP_BAD_REQUEST_MESSAGE                     = 'Bad Request'; // 400
    public const HTTP_UNAUTHORIZED_MESSAGE                    = 'Unauthorized'; // 401
    public const HTTP_PAYMENT_REQUIRED_MESSAGE                = 'Payment Required'; // 402
    public const HTTP_FORBIDDEN_MESSAGE                       = 'Forbidden'; // 403
    public const HTTP_NOT_FOUND_MESSAGE                       = 'Not Found'; // 404
    public const HTTP_METHOD_NOT_ALLOWED_MESSAGE              = 'Method Not Allowed'; // 405
    public const HTTP_NOT_ACCEPTABLE_MESSAGE                  = 'Not Acceptable'; // 406
    public const HTTP_PROXY_AUTHENTICATION_REQUIRED_MESSAGE   = 'Proxy Authentication Required'; // 407
    public const HTTP_REQUEST_TIMEOUT_MESSAGE                 = 'Request Timeout'; // 408
    public const HTTP_CONFLICT_MESSAGE                        = 'Conflict'; // 409
    public const HTTP_GONE_MESSAGE                            = 'Gone'; // 410
    public const HTTP_LENGTH_REQUIRED_MESSAGE                 = 'Length Required'; // 411
    public const HTTP_PRECONDITION_FAILED_MESSAGE             = 'Precondition Failed'; // 412
    public const HTTP_PAYLOAD_TOO_LARGE_MESSAGE               = 'Payload Too Large'; // 413
    public const HTTP_URI_TOO_LONG_MESSAGE                    = 'URI Too Long'; // 414
    public const HTTP_UNSUPPORTED_MEDIA_TYPE_MESSAGE          = 'Unsupported Media Type'; // 415
    public const HTTP_RANGE_NOT_SATISFIABLE_MESSAGE           = 'Range Not Satisfiable'; // 416
    public const HTTP_EXPECTATION_FAILED_MESSAGE              = 'Expectation Failed'; // 417
    public const HTTP_IM_A_TEAPOT_MESSAGE                     = 'I\'m a teapot'; // 418
    public const HTTP_MISDIRECTED_REQUEST_MESSAGE             = 'Misdirected Request'; // 421
    public const HTTP_UNPROCESSABLE_ENTITY_MESSAGE            = 'Unprocessable Entity'; // 422
    public const HTTP_LOCKED_MESSAGE                          = 'Locked'; // 423
    public const HTTP_FAILED_DEPENDENCY_MESSAGE               = 'Failed Dependency'; // 424
    public const HTTP_TOO_EARLY_MESSAGE                       = 'Too Early'; // 425
    public const HTTP_UPGRADE_REQUIRED_MESSAGE                = 'Upgrade Required'; // 426
    public const HTTP_PRECONDITION_REQUIRED_MESSAGE           = 'Precondition Required'; // 428
    public const HTTP_TOO_MANY_REQUESTS_MESSAGE               = 'Too Many Requests'; // 429
    public const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE_MESSAGE = 'Request Header Fields Too Large'; // 431
    public const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS_MESSAGE   = 'Unavailable For Legal Reasons'; // 451
    public const HTTP_CLIENT_CLOSED_REQUEST_MESSAGE           = 'Client Closed Request'; // 499
    public const HTTP_INTERNAL_SERVER_ERROR_MESSAGE           = 'Internal Server Error'; // 500
    public const HTTP_NOT_IMPLEMENTED_MESSAGE                 = 'Not Implemented'; // 501
    public const HTTP_BAD_GATEWAY_MESSAGE                     = 'Bad Gateway'; // 502
    public const HTTP_SERVICE_UNAVAILABLE_MESSAGE             = 'Service Unavailable'; // 503
    public const HTTP_GATEWAY_TIMEOUT_MESSAGE                 = 'Gateway Timeout'; // 504
    public const HTTP_HTTP_VERSION_NOT_SUPPORTED_MESSAGE      = 'HTTP Version Not Supported'; // 505
    public const HTTP_VARIANT_ALSO_NEGOTIATES_MESSAGE         = 'Variant Also Negotiates'; // 506
    public const HTTP_INSUFFICIENT_STORAGE_MESSAGE            = 'Insufficient Storage'; // 507
    public const HTTP_LOOP_DETECTED_MESSAGE                   = 'Loop Detected'; // 508
    public const HTTP_NOT_EXTENDED_MESSAGE                    = 'Not Extended'; // 510
    public const HTTP_NETWORK_AUTHENTICATION_REQUIRED_MESSAGE = 'Network Authentication Required'; // 511
    public const HTTP_NETWORK_CONNECT_TIMEOUT_ERROR_MESSAGE   = 'Network Connect Timeout Error'; // 599

    public static function getMessage($code)
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants();
        $message = '';
        foreach ($constants as $key => $value) {
            if ($value == $code) {
                $message = $reflection->getConstant($key . '_MESSAGE');
                break;
            }
        }
        return $message;
    }
}
