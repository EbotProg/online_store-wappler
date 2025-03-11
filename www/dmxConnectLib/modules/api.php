<?php

namespace modules;

use \lib\core\Module;
use \lib\oauth\Oauth2;

class api extends Module
{
    public function get($options) {
        $options->method = 'GET';
        return $this->send($options);
    }

    public function post($options) {
        $options->method = 'POST';
        return $this->send($options);
    }

    public function put($options) {
        $options->method = 'PUT';
        return $this->send($options);
    }

    public function patch($options) {
        $options->method = 'PATCH';
        return $this->send($options);
    }

    public function delete($options) {
        $options->method = 'DELETE';
        return $this->send($options);
    }

    public function send($options) {
        option_require($options, 'url');
        option_default($options, 'method', 'GET');
        option_default($options, 'data', NULL);
        option_default($options, 'dataType', 'auto');
        option_default($options, 'verifySSL', FALSE);
        option_default($options, 'params', array());
        option_default($options, 'headers', array());
        option_default($options, 'username', '');
        option_default($options, 'password', '');
        option_default($options, 'oauth', NULL);
        option_default($options, 'throwErrors', FALSE);
        option_default($options, 'passErrors', TRUE);

        $options = $this->app->parseObject($options);

        $url = $options->url;
        $method = $options->method;
        $headers = (array)$options->headers;
        $data = NULL;
        
        $handle = curl_init();
        
        if ($method != 'GET') {
            $data = $options->data;
            $dataType = $options->dataType;

            if ($dataType == 'auto' && $method == 'POST') {
                $dataType = 'x-www-form-urlencoded';
            }

            if ($dataType != 'auto' && !isset($headers['Content-Type'])) {
                $headers['Content-Type'] = 'application/' . $dataType;
            }

            if (!empty($data)) {
                if ($dataType == 'x-www-form-urlencoded') {
                    $data = http_build_query($options->data);
                } else {
                    $data = json_encode($options->data);
                }
            }
            
            if ($method == 'POST') {
                curl_setopt($handle, CURLOPT_POST, TRUE);
            }

            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        }

        if ($options->oauth) {
            //$oauth2 = $this->app->scope->get($options->oauth);
            $oauth2 = Oauth2::get($this->app, $options->oauth);
            if ($oauth2 && $oauth2->access_token) {
                $headers['Authorization'] = 'Bearer ' . $oauth2->access_token;
            }
        }

        foreach ($options->params as $name => $value) {
            if (strpos($url, '?') !== FALSE) {
                $url .= '&';
            } else {
                $url .= '?';
            }

            $url .= curl_escape($handle, (string)$name) . '=' . curl_escape($handle, (string)$value);
        }

        curl_setopt_array($handle, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTPHEADER => $this->getFormatterHeaders($headers),
            CURLOPT_HEADER => TRUE,
            CURLOPT_ENCODING => '',
            CURLOPT_SSL_VERIFYPEER => $options->verifySSL
        ]);

        if (isset($options->timeout)) {
            curl_setopt($handle, CURLOPT_TIMEOUT, $options->timeout);
        }

        if (!empty($options->username)) {
            curl_setopt_array($handle, [
                CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                CURLOPT_USERPWD => $options->username . ':' . $options->password
            ]);
        }

        $response = curl_exec($handle);
        $errorno = curl_errno($handle);
        $error = curl_error($handle);
        $info = curl_getinfo($handle);

        curl_close($handle);

        if ($errorno) {
            $error_codes = array(
                1  => 'CURLE_UNSUPPORTED_PROTOCOL',
                2  => 'CURLE_FAILED_INIT',
                3  => 'CURLE_URL_MALFORMAT',
                4  => 'CURLE_URL_MALFORMAT_USER',
                5  => 'CURLE_COULDNT_RESOLVE_PROXY',
                6  => 'CURLE_COULDNT_RESOLVE_HOST',
                7  => 'CURLE_COULDNT_CONNECT',
                8  => 'CURLE_FTP_WEIRD_SERVER_REPLY',
                9  => 'CURLE_REMOTE_ACCESS_DENIED',
                11 => 'CURLE_FTP_WEIRD_PASS_REPLY',
                13 => 'CURLE_FTP_WEIRD_PASV_REPLY',
                14 => 'CURLE_FTP_WEIRD_227_FORMAT',
                15 => 'CURLE_FTP_CANT_GET_HOST',
                17 => 'CURLE_FTP_COULDNT_SET_TYPE',
                18 => 'CURLE_PARTIAL_FILE',
                19 => 'CURLE_FTP_COULDNT_RETR_FILE',
                21 => 'CURLE_QUOTE_ERROR',
                22 => 'CURLE_HTTP_RETURNED_ERROR',
                23 => 'CURLE_WRITE_ERROR',
                25 => 'CURLE_UPLOAD_FAILED',
                26 => 'CURLE_READ_ERROR',
                27 => 'CURLE_OUT_OF_MEMORY',
                28 => 'CURLE_OPERATION_TIMEDOUT',
                30 => 'CURLE_FTP_PORT_FAILED',
                31 => 'CURLE_FTP_COULDNT_USE_REST',
                33 => 'CURLE_RANGE_ERROR',
                34 => 'CURLE_HTTP_POST_ERROR',
                35 => 'CURLE_SSL_CONNECT_ERROR',
                36 => 'CURLE_BAD_DOWNLOAD_RESUME',
                37 => 'CURLE_FILE_COULDNT_READ_FILE',
                38 => 'CURLE_LDAP_CANNOT_BIND',
                39 => 'CURLE_LDAP_SEARCH_FAILED',
                41 => 'CURLE_FUNCTION_NOT_FOUND',
                42 => 'CURLE_ABORTED_BY_CALLBACK',
                43 => 'CURLE_BAD_FUNCTION_ARGUMENT',
                45 => 'CURLE_INTERFACE_FAILED',
                47 => 'CURLE_TOO_MANY_REDIRECTS',
                48 => 'CURLE_UNKNOWN_TELNET_OPTION',
                49 => 'CURLE_TELNET_OPTION_SYNTAX',
                51 => 'CURLE_PEER_FAILED_VERIFICATION',
                52 => 'CURLE_GOT_NOTHING',
                53 => 'CURLE_SSL_ENGINE_NOTFOUND',
                54 => 'CURLE_SSL_ENGINE_SETFAILED',
                55 => 'CURLE_SEND_ERROR',
                56 => 'CURLE_RECV_ERROR',
                58 => 'CURLE_SSL_CERTPROBLEM',
                59 => 'CURLE_SSL_CIPHER',
                60 => 'CURLE_SSL_CACERT',
                61 => 'CURLE_BAD_CONTENT_ENCODING',
                62 => 'CURLE_LDAP_INVALID_URL',
                63 => 'CURLE_FILESIZE_EXCEEDED',
                64 => 'CURLE_USE_SSL_FAILED',
                65 => 'CURLE_SEND_FAIL_REWIND',
                66 => 'CURLE_SSL_ENGINE_INITFAILED',
                67 => 'CURLE_LOGIN_DENIED',
                68 => 'CURLE_TFTP_NOTFOUND',
                69 => 'CURLE_TFTP_PERM',
                70 => 'CURLE_REMOTE_DISK_FULL',
                71 => 'CURLE_TFTP_ILLEGAL',
                72 => 'CURLE_TFTP_UNKNOWNID',
                73 => 'CURLE_REMOTE_FILE_EXISTS',
                74 => 'CURLE_TFTP_NOSUCHUSER',
                75 => 'CURLE_CONV_FAILED',
                76 => 'CURLE_CONV_REQD',
                77 => 'CURLE_SSL_CACERT_BADFILE',
                78 => 'CURLE_REMOTE_FILE_NOT_FOUND',
                79 => 'CURLE_SSH',
                80 => 'CURLE_SSL_SHUTDOWN_FAILED',
                81 => 'CURLE_AGAIN',
                82 => 'CURLE_SSL_CRL_BADFILE',
                83 => 'CURLE_SSL_ISSUER_ERROR',
                84 => 'CURLE_FTP_PRET_FAILED',
                84 => 'CURLE_FTP_PRET_FAILED',
                85 => 'CURLE_RTSP_CSEQ_ERROR',
                86 => 'CURLE_RTSP_SESSION_ERROR',
                87 => 'CURLE_FTP_BAD_FILE_LIST',
                88 => 'CURLE_CHUNK_FAILED'
            );

            throw new \Exception($error ? $error : $error_codes[$errorno], $errorno);
        }

        $headerSize = $info['header_size'];
        $rawHeaders = substr($response, 0, $headerSize);
        $rawBody = substr($response, $headerSize);
        $status = $info['http_code'];

        if ($status >= 400) {
            if ($options->throwErrors) {
                throw new \Exception($status . ' ' . $this->parseBody($rawBody));
            }

            if ($options->passErrors) {
                $this->app->response->end($status, $this->parseBody($rawBody));
            }
        }

        return (object)[
            'status' => $status,
            'headers' => $this->parseHeaders($rawHeaders),
            'data' => $this->parseBody($rawBody)
        ];
    }

    protected function parseHeaders($rawHeaders) {
        if (function_exists('http_parse_headers')) {
            return http_parse_headers($rawHeaders);
        } else {
            $key = '';
            $headers = array();

            foreach (explode("\n", $rawHeaders) as $i => $h) {
                $h = explode(':', $h, 2);

                if (isset($h[1])) {
                    if (!isset($headers[$h[0]])) {
                        $headers[$h[0]] = trim($h[1]);
                    } elseif (is_array($headers[$h[0]])) {
                        $headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1])));
                    } else {
                        $headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1])));
                    }

                    $key = $h[0];
                } else {
                    if (substr($h[0], 0, 1) == "\t") {
                        $headers[$key] .= "\r\n\t".trim($h[0]);
                    } elseif (!$key) {
                        $headers[0] = trim($h[0]);
                    }
                }
            }

            return $headers;
        }
    }

    protected function remove_utf8_bom($text)
    {
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }

    protected function parseBody($rawBody) {
        $rawBody = $this->remove_utf8_bom($rawBody);

        $json = json_decode($rawBody);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $json;
        }

        return $rawBody;
    }

    protected function getFormatterHeaders($headers = array()) {
        $formattedHeaders = array();

        foreach ($headers as $key => $val) {
            $formattedHeaders[] = $this->getHeaderString($key, $val);
        }

        if (!array_key_exists('user-agent', $headers)) {
            $formattedHeaders[] = 'user-agent: ServerConnect/1.0';
        }

        if (!array_key_exists('accept', $headers)) {
            $formattedHeaders[] = 'accept: application/json';
        }

        if (!array_key_exists('expect', $headers)) {
            $formattedHeaders[] = 'expect:';
        }

        return $formattedHeaders;
    }

    protected function getHeaderString($key, $val) {
        $key = trim(strtolower($key));
        return $key . ':' . $val;
    }
}
