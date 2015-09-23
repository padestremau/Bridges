<?php

namespace Bridges\RedactorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\JsonResponse,
    Symfony\Component\Validator\Constraints\Image,
    Symfony\Component\Validator\Constraints\File,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\Validator\Exception\ValidatorException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/redactor")
 */
class RedactorController extends Controller
{
    /**
     * @return \Bridges\RedactorBundle\Model\RedactorService
     */
    protected function getRedactor()
    {
        return $this->get('redactor.service');
    }

    /**
     * Check is user allow to upload files to this env
     *
     * @param $env
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    protected function isAllowException($env)
    {
        if (!$this->getRedactor()->isAllowed($env)) {
            //            throw new AccessDeniedException('You are not allowed to upload files');
        }
    }

    /**
     * @Method({"POST"})
     * @Route("/imageUpload/{env}", name="redactor_image_upload")
     */
    public function imageUploadAction($env)
    {
        return $this->upload('image', $env);
    }

    /**
     * @Method({"POST"})
     * @Route("/fileUpload/{env}", name="redactor_file_upload")
     */
    public function fileUploadAction($env)
    {

        return $this->upload('file', $env);
    }


    /**
     * @Route("/clipboardUpload/{env}", name="redactor_clipboard_upload")
     */
    public function clipboardUploadAction($env)
    {
        $upFile = base64_decode($this->getRequest()->request->get('data'));

        $filename = sha1(uniqId()) . date('YmdHis') . ".png";

        // $dir = "c:/Users/Dell/Documents/Github/BridgesCapital/web/uploads/images/";

        $config = $this->getRedactor()->getConfiguration($env);
        $dir = $this->get('kernel')->getRootDir() . $config['upload_image']['dir'];
        $uploadUrl = $dir . $filename;
        file_put_contents($uploadUrl, $upFile);
        /*$config = $this->getConfiguration($envName);
        $config = $config['upload_' . $type];
        $uploadUrl = $config['web_dir'];*/
        $response = array(
            "filelink" => "/uploads/images/" . $filename
        );

        return $response;
    }


    /**
     * Validate and upload files and images
     *
     * @param $type
     * @param $env
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function upload($type, $env)
    {
        $response = array('error' => true);
        try {
            $this->isAllowException($env);
            /* @var $upFile \Symfony\Component\HttpFoundation\File\UploadedFile */
            if ($type == 'clip') {
                return $this->clipboardUploadAction($env);
            } else {
                $upFile = $this->getRequest()->files->get('file');
                $this->getRedactor()->validateFile($type, $env, $upFile);
                $response = $this->getRedactor()->uploadFile($type, $env, $upFile);
            }
        } catch (ValidatorException $e) {
            $response['message'] = $e->getMessage();
        } catch (AccessDeniedException $e) {
            $response['message'] = $e->getMessage();
        } catch (\Exception $e) {
            $response['message'] = 'Unknown error';
            $this->get('logger')->addError($e);
        }

        return new JsonResponse($response);
    }

}
