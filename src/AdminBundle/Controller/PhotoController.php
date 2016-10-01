<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use CoreBundle\Entity\Photo;
use Symfony\Component\HttpFoundation\JsonResponse;

class PhotoController extends Controller {

    public function uploadAction(Request $request) {
        if (!$this->get('tleroch_admin.security')->verify()) {
            return new JsonResponse(array(
                'success' => false,
                'message' => 'Invalid rights'
            ));
        }

        if (empty($request->files)) {
            return new JsonResponse(array(
                'success' => false,
                'message' => 'Missing parameter'
            ));
        }

        $file = $request->files->get('file');

        try {
            $uploaded = $this->get('tleroch_admin.file_uploader')->upload($this->getParameter('tmp_photos_folder_upload'), $file);
        } catch (FileException $e) {
            return new JsonResponse(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }

        return new JsonResponse(array(
            'success' => true,
            'file' => $uploaded->getFilename(),
            'url' => $this->get('router')->getContext()->getBaseUrl() . '/../' . $this->getParameter('tmp_photos_folder_upload') . $uploaded->getFilename(),
            'mimetype' => $uploaded->getMimeType()
        ));
    }

}
