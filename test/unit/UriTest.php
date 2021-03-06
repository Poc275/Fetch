<?php
namespace Gt\Fetch;

use Gt\Fetch\Test\Helper\Helper;
use PHPUnit\Framework\TestCase;

class UriTest extends TestCase {

	public function testSimpleUrl() {
		$uri = new Uri(Helper::URI_SIMPLE);

		$this->assertEquals("fake", $uri->getScheme());
		$this->assertEquals("php.gt", $uri->getAuthority());
		$this->assertEquals("", $uri->getUserInfo());
		$this->assertEquals("php.gt", $uri->getHost());
		$this->assertNull($uri->getPort());
		$this->assertEquals("/fetch", $uri->getPath());
		$this->assertEquals("", $uri->getQuery());
		$this->assertEquals("", $uri->getFragment());
	}

	public function testComplexUrl() {
		$uri = new Uri(Helper::URI_COMPLEX);

		$this->assertEquals("fake", $uri->getScheme());
		$this->assertEquals("someuser:somepassword@php.gt:8008", $uri->getAuthority());
		$this->assertEquals("someuser:somepassword", $uri->getUserInfo());
		$this->assertEquals("php.gt", $uri->getHost());
		$this->assertEquals(8008, $uri->getPort());
		$this->assertEquals("/fetch", $uri->getPath());
		$this->assertEquals("id=105", $uri->getQuery());
		$this->assertEquals("example", $uri->getFragment());
	}

	public function testWithScheme() {
		$uri = new Uri(Helper::URI_SIMPLE);
		$newUri = $uri->withScheme("updated");

		$this->assertEquals("updated", $newUri->getScheme());
		$this->assertEquals("updated://php.gt/fetch", (string)$newUri);
	}

	public function testWithUserInfo() {
		$uri = new Uri(Helper::URI_SIMPLE);
		$newUri = $uri->withUserInfo("admin", "secret");

		$this->assertEquals("admin:secret", $newUri->getUserInfo());
		$this->assertEquals("fake://admin:secret@php.gt/fetch", (string)$newUri);
	}

	public function testWithHost() {
		$uri = new Uri(Helper::URI_SIMPLE);
		$newUri = $uri->withHost("phpgt.com");

		$this->assertEquals("phpgt.com", $newUri->getHost());
		$this->assertEquals("fake://phpgt.com/fetch", (string)$newUri);
	}

	public function testWithPort() {
		$uri = new Uri(Helper::URI_SIMPLE);
		$newUri = $uri->withPort(1234);

		$this->assertEquals(1234, $newUri->getPort());
		$this->assertEquals("fake://php.gt:1234/fetch", (string)$newUri);
	}

	public function testWithPath() {
		$uri = new Uri(Helper::URI_SIMPLE);
		$newUri = $uri->withPath("/webengine");

		$this->assertEquals("/webengine", $newUri->getPath());
		$this->assertEquals("fake://php.gt/webengine", (string)$newUri);
	}

	public function testWithQuery() {
		$uri = new Uri(Helper::URI_SIMPLE);
		$newUri = $uri->withQuery("name=Scarlett");

		$this->assertEquals("name=Scarlett", $newUri->getQuery());
		$this->assertEquals("fake://php.gt/fetch?name=Scarlett", (string)$newUri);
	}

	public function testWithFragment() {
		$uri = new Uri(Helper::URI_SIMPLE);
		$newUri = $uri->withFragment("example");

		$this->assertEquals("example", $newUri->getFragment());
		$this->assertEquals("fake://php.gt/fetch#example", (string)$newUri);
	}
}