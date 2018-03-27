<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 21/02/2018
 * Time: 09:44
 */

use Edogawa\Core\Validator\Validation;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{

    public function setUp()
    {
        $this->validation = new Validation();
    }

    /**
     * @test
     * @dataProvider emailProvider
     */
    public function testValidateEmail($email)
    {
        $this->assertTrue($this->validation->validateEmail($email));
    }

    public function emailProvider()
    {
        return [
            ['email@example.com'],
            ['firstname.lastname@example.com'],
            ['email@subdomain.example.com'],
            ['firstname+lastname@example.com'],
            ['email@123.123'],
            ['1234567890@example.com'],
            ['email@example-one.com'],
            ['_______@example.com'],
            ['email@example.name'],
            ['email@example.museum'],
            ['email@example.co.jp'],
            ['firstname-lastname@example.com']
        ];
    }

    /**
     * @test
     * @dataProvider numberProvider
     */
    public function testValidateNumber($number)
    {
        $this->assertTrue($this->validation->validateNumber($number));
    }

    public function numberProvider()
    {
        return [
            [1],
            [100],
            [1000000000000000000],
            [0]
        ];
    }

    /**
     * @test
     * @dataProvider telProvider
     */
    public function testValidateTel($tel)
    {
        $this->assertTrue($this->validation->validateTel($tel));
    }

    public function telProvider()
    {
        return [
            ['97 67 13 92'],
            ['97-67-13-92'],
            ['00228 97-67-13-92'],
            ['+228 97-67-13-92'],
            ['+228 97 67 13 92'],
            ['+1 980 789 123 456']
        ];
    }

    /**
     * @test
     * @dataProvider siteWebProvider
     */
    public function testValidateSiteWeb($siteWeb)
    {
        $this->assertTrue($this->validation->validateSiteWeb($siteWeb));
    }

    public function siteWebProvider()
    {
        return [
            ['http://www.foo.com'],
            ['http://foo.com/blah_blah'],
            ['http://foo.com/blah_blah/'],
            ['http://foo.com/blah_blah_(wikipedia)'],
            ['http://foo.com/blah_blah_(wikipedia)_(again)'],
            ['http://www.example.com/wpstyle/?p=364'],
            ['https://www.example.com/foo/?bar=baz&inga=42&quux'],
            ['http://userid:password@example.com:8080'],
            ['http://userid:password@example.com:8080/'],
            ['http://userid@example.com'],
            ['http://userid@example.com/'],
            ['http://userid@example.com:8080'],
            ['http://userid@example.com:8080/'],
            ['http://userid:password@example.com'],
            ['http://userid:password@example.com/']
        ];
    }
    /**
     * @test
     * @dataProvider notSiteWebProvider
     */
    public function testValidateNotSiteWeb($siteWeb)
    {
        $this->assertFalse($this->validation->validateSiteWeb($siteWeb));
    }

    public function notSiteWebProvider()
    {
        return [
            ['http://'],
            ['http://.'],
            ['http://..'],
            ['http://../'],
            ['http://?'],
            ['http://??'],
            ['http://??/'],
            ['http://#'],
            ['http://##'],
            ['http://##/'],
            ['http://foo.bar?q=Spaces should be encoded'],
            ['//'],
            ['//a'],
            ['///a'],
            ['///'],
            ['http:///a'],
            ['foo.com'],
            ['rdar://1234'],
            ['h://test'],
            ['http:// shouldfail.com'],
            [':// should fail'],
            ['http://foo.bar/foo(bar)baz quux'],
            ['ftps://foo.bar/'],
            ['http://-error-.invalid/'],
            ['http://0.0.0.0'],
            ['http://10.1.1.0'],
            ['http://10.1.1.255'],
            ['http://224.1.1.1'],
            ['http://1.1.1.1.1'],
            ['http://123.123.123'],
            ['http://3628126748'],
        ];
    }

    /**
     * @test
     */
    public function testVerifyIfContainsSpecialChars()
    {
        $this->assertTrue($this->validation->verifyIfContainsSpecialChars('@'));
    }

    /**
     * @test
     */
    public function testValidate()
    {
        $tab = [
            'IDPARRAIN' => [
                'value' => 'password',
                'pattern' => 'required|min:3|max:15|equal:IDP:password'
            ],
            'IDED' => [
                'value' => 'contact@edframework.com',
                'pattern' => 'required|min:3|max:100|email'
            ]
        ];
        $this->assertTrue($this->validation->validate($tab));
        $this->assertTrue(true);
    }

}
