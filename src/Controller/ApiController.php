<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;
use App\Api\ResponseFactory;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\DataTransferObject\UserDto;
use App\DataTransferObject\ExistingUserDto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api", name="api.")
 */
class ApiController extends AbstractFOSRestController {

    private UserService $userService;
    private ResponseFactory $responseFactory;
    
    public function __construct(UserService $userService, ResponseFactory $responseFactory) {
        $this->userService = $userService;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @Rest\Post("/create", name="create_user")
     * @ParamConverter("userDto", converter="fos_rest.request_body")
     */
    public function createUser(UserDto $userDto) : Response {
        $user = $this->userService->createUser($userDto);
        return $this->responseFactory->responseCorrect($user);
    }

    /**
     * @Rest\Post("/activate", name="activate_user")
     * @ParamConverter("existingUserDto", converter="fos_rest.request_body")
     */
    public function activateUser(ExistingUserDto $existingUserDto) : Response {
        $user = $this->userService->activateUser($existingUserDto);
        return $this->responseFactory->responseCorrect($user);
    }

    /**
     * @Rest\Post("/unsubscribe", name="unsubscribe_user")
     * @ParamConverter("existingUserDto", converter="fos_rest.request_body")
     */
    public function unsubscribe(ExistingUserDto $existingUserDto) : Response {
        $this->userService->unsubscribe($existingUserDto);
        return $this->responseFactory->responseCorrect('');
    }
}
