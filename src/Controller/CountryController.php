<?php

namespace App\Controller;


use Exception;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

use App\Model\Exceptions\InvalidISOCodeException;
use App\Model\Exceptions\CountryNotFoundException;
use App\Model\Exceptions\DuplicatedCodeException;
use App\Model\Exceptions\InvalidValueException;
use App\Model\Exceptions\CodeCollisionException;

use App\Model\Country;
use App\Model\CountryScenarios;

#[Route(path: 'api/country', name: 'app_api_country')]
class CountryController extends AbstractController
{
    public function __construct(
        private readonly CountryScenarios $countries
    ) {

    }


    #[Route(path: '', name: 'app_api_country_root', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        return $this->json(data: $this->countries->getAll());
    }
     
    #[Route(path:'/{code}', name:'app_api_country_code', methods: ['GET'])] 
    public function get(string $code): JsonResponse {
        try {
            $country = $this->countries->getByCode($code);
            return $this->json(data: $country);
        } catch (InvalidISOCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        } catch (CountryNotFoundException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 404);
            return $response;
        }
    }

    #[Route(path: '', name: 'app_api_country_add', methods: ['POST'])]
    public function add(#[MapRequestPayload] Country $country) : JsonResponse {
        try {
            $this->countries->store(country: $country);
            return $this->json(data: null, status: 204);
        } catch (InvalidISOCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        } catch (InvalidValueException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        } catch (DuplicatedCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 409);
            return $response;
        } 
    }

    #[Route(path: '/{code}', name: 'app_api_country_edit', methods:['PATCH'])]
    public function edit(string $code,#[MapRequestPayload] Country $country)
    {
        try {
            $this->countries->edit(country: $country,code: $code);
            return $this->json(data: $country, status: 200);
        } catch (InvalidISOCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        } catch (InvalidValueException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        }  catch (CountryNotFoundException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 404);
            return $response;
        } catch (CodeCollisionException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 409);
            return $response;
        }
    }

    #[Route(path:'/{code}', name:'app_api_country_del', methods: ['DELETE'])] 
    public function delete(string $code): JsonResponse {
        try {
            $this->countries->delete($code);
            return $this->json(data: null,status: 204);
        } catch (InvalidISOCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        } catch (CountryNotFoundException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 404);
            return $response;
        }
    }

    private function buildErrorResponse(Exception $ex): JsonResponse {
        return $this->json(data: [
            'errorCode' => $ex->getCode(),
            'errorMessage' => $ex->getMessage(),
        ]);
    } 
}
