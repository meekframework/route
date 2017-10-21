<?php declare(strict_types=1);

namespace Meek\Route;

use PHPUnit\Framework\TestCase;

class HttpClientErrorTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testIsARuntimeException()
    {
        $httpClientError = new HttpClientError(404);

        $this->assertInstanceOf('RuntimeException', $httpClientError);
    }

    /**
     * @covers \Meek\Route\HttpClientError::__construct
     */
    public function testThrowsExceptionIfCodeIsTooLowToBeACientErrorStatusCode()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('A client error status code ("4xx") was not provided');

        $httpClientError = new HttpClientError(200);
    }

    /**
     * @covers \Meek\Route\HttpClientError::__construct
     */
    public function testThrowsExceptionIfCodeIsTooHighToBeACientErrorStatusCode()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('A client error status code ("4xx") was not provided');

        $httpClientError = new HttpClientError(500);
    }

    /**
     * @covers \Meek\Route\HttpClientError::__construct
     */
    public function testSetsCodeToStatusCode()
    {
        $httpClientError = new HttpClientError(404);

        $this->assertEquals(404, $httpClientError->getCode());
    }

    /**
     * @dataProvider reasonPhrasesForStatusCodes
     * @covers \Meek\Route\HttpClientError::getReasonPhraseFromStatusCode
     */
    public function testSetsMessageToReasonPhrase($statusCode, $reasonPhrase)
    {
        $httpClientError = new HttpClientError($statusCode);

        $this->assertEquals($reasonPhrase, $httpClientError->getMessage());
    }

    /**
     * @covers \Meek\Route\HttpClientError::__construct
     */
    public function testHeadersAreInitiallyEmpty()
    {
        $httpClientError = new HttpClientError(404);

        $this->assertEmpty($httpClientError->getHeaders());
    }

    /**
     * @covers \Meek\Route\HttpClientError::getStatusCode
     */
    public function testCanGetStatusCode()
    {
        $httpClientError = new HttpClientError(404);

        $this->assertEquals(404, $httpClientError->getStatusCode());
    }

    /**
     * @dataProvider reasonPhrasesForStatusCodes
     * @covers \Meek\Route\HttpClientError::getReasonPhrase
     */
    public function testCanGetReasonPhrase($statusCode, $reasonPhrase)
    {
        $httpClientError = new HttpClientError($statusCode);

        $this->assertEquals($reasonPhrase, $httpClientError->getReasonPhrase());
    }

    /**
     * @covers \Meek\Route\HttpClientError::getHeaders
     */
    public function testCanGetHeaders()
    {
        $httpClientError = new HttpClientError(404, [
            'allow' => ['get', 'post']
        ]);

        $this->assertArrayHasKey('allow', $httpClientError->getHeaders());
    }

    public function reasonPhrasesForStatusCodes()
    {
        return [
            'test 400' => [400, 'Bad Request'],
            'test 401' => [401, 'Unauthorized'],
            'test 402' => [402, 'Payment Required'],
            'test 403' => [403, 'Forbidden'],
            'test 404' => [404, 'Not Found'],
            'test 405' => [405, 'Method Not Allowed'],
            'test 406' => [406, 'Not Acceptable'],
            'test 407' => [407, 'Proxy Authentication Required'],
            'test 408' => [408, 'Request Timeout'],
            'test 409' => [409, 'Conflict'],
            'test 410' => [410, 'Gone'],
            'test 411' => [411, 'Length Required'],
            'test 412' => [412, 'Precondition Failed'],
            'test 413' => [413, 'Payload Too Large'],
            'test 414' => [414, 'URI Too Long'],
            'test 415' => [415, 'Unsupported Media Type'],
            'test 416' => [416, 'Range Not Satisfiable'],
            'test 417' => [417, 'Expectation Failed'],
            'test 418' => [418, 'I\'m a teapot'],       // probably should be removed...
            'test 421' => [421, 'Misdirected Request'],
            'test 422' => [422, 'Unprocessable Entity'],
            'test 423' => [423, 'Locked'],
            'test 424' => [424, 'Failed Dependency'],
            'test 426' => [426, 'Upgrade Required'],
            'test 428' => [428, 'Precondition Required'],
            'test 429' => [429, 'Too Many Requests'],
            'test 431' => [431, 'Request Header Fields Too Large'],
            'test 451' => [451, 'Unavailable For Legal Reasons']
        ];
    }
}
