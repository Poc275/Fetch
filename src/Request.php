<?php
namespace phpgt\fetch;

class Request {

const METHOD_GET = "get";
const METHOD_HEAD = "head";
const METHOD_POST = "post";
const METHOD_PUT = "put";
const METHOD_DELETE = "delete";
const METHOD_TRACE = "trace";
const METHOD_OPTION = "options";
const METHOD_CONNECT = "connect";
const METHOD_PATCH = "patch";
const AVAILABLE_METHODS = [
	self::METHOD_GET,
	self::METHOD_HEAD,
	self::METHOD_POST,
	self::METHOD_PUT,
	self::METHOD_DELETE,
	self::METHOD_TRACE,
	self::METHOD_OPTION,
	self::METHOD_CONNECT,
	self::METHOD_PATCH,
];

const REDIRECT_FOLLOW = "follow";
const REDIRECT_ERROR = "error";
const REDIRECT_MANUAL = "manual";
const AVAILABLE_REDIRECTS = [
	self::REDIRECT_FOLLOW,
	self::REDIRECT_ERROR,
	self::REDIRECT_MANUAL,
];

const CREDENTIAL_OMIT = "omit";
const CREDENTIAL_SAME_ORIGIN = "same-origin";
const CREDENTIAL_INCLUDE = "include";

const AVAILABLE_CREDENTIALS = [
	self::CREDENTIAL_OMIT,
	self::CREDENTIAL_SAME_ORIGIN,
	self::CREDENTIAL_INCLUDE,
];

private $headers;
private $body;
private $credentials;
private $redirect;
private $referer;
private $integrity;

/**
 * @param string $uri Direct URI of the object to be fetched
 * @param array $init Optional associative array of options
 */
public function __construct(string $uri, array $init = []) {
	$method = self::METHOD_GET;
	if(!empty($init["method"])) {
		$method = strtolower($init["method"]);

		if(!in_array($method, self::AVAILABLE_METHODS)) {
			throw new HttpMethodException($method);
		}
	}

	if(!empty($init["headers"])
	&& is_array($init["headers"])) {
		$this->headers = $init["headers"];
	}

	if(!empty($init["body"])) {
		if(($method !== self::METHOD_GET || $method !== self::METHOD_HEAD)) {
			throw new HttpInitException("body");
		}

		$this->body = $init["body"];
	}

	if(!empty($init["credentials"])) {
		if(!in_array(
		strtolower($init["credentials"]), self::AVAILABLE_CREDENTIALS)) {
			throw new HttpInitException("credentials");
		}
	}

	if(!empty($init["redirect"])) {
		if(!in_array(
		strtolower($init["redirect"]), self::AVAILABLE_REDIRECTS)) {
			throw new HttpInitException("redirect");
		}

		$this->redirect = $init["redirect"];
	}

	if(!empty($init["referer"])) {
		if(!is_string($init["referer"])) {
			throw new HttpInitException("referer");
		}

		$this->referer = $init["referer"];
	}

	if(!empty($init["integrity"])) {
		if(!is_string($init["integrity"])) {
			throw new HttpInitException("integrity");
		}

		$this->integrity = $init["integrity"];
	}
}

}#