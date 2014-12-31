<?php

/**
 * Description of TestCase
 *
 * @author desarrollo
 */
class SimpleJsonTestCase extends Orchestra\Testbench\TestCase {

    protected function getPackageProviders() {
        return array('Joselfonseca\LaravelApiTools\LaravelApiToolsServiceProvider');
    }

    public function testSimpleJsonOk() {
        $data = [
            'id' => 1,
            'name' => "Test Case for Json"
        ];
        $response = Joselfonseca\LaravelApiTools\ApiToolsResponder::simpleJson($data);
        $this->assertEquals(json_encode($data), $response->getContent());
    }
    
    public function testSimpleJsonStatusOk() {
        $data = [
            'id' => 1,
            'name' => "Test Case for Json"
        ];
        $response = Joselfonseca\LaravelApiTools\ApiToolsResponder::simpleJson($data);
        $this->assertEquals(200, $response->getstatusCode());
    }
    
    public function testSimpleJsonStatusCode() {
        $data = [
            'id' => 1,
            'name' => "Test Case for Json"
        ];
        $response = Joselfonseca\LaravelApiTools\ApiToolsResponder::simpleJson($data, 401);
        $this->assertEquals(401, $response->getstatusCode());
    }
    
    public function testSimpleJsonHeaderContentType() {
        $data = [
            'id' => 1,
            'name' => "Test Case for Json"
        ];
        $response = Joselfonseca\LaravelApiTools\ApiToolsResponder::simpleJson($data);
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
    }

}
