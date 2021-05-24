<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Contracts\Translation\TranslatorInterface;


class HomeController extends AbstractController
{

    public function index()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
      return $this->render('home/index.html.twig'
//, [
//            'controller_name' => 'HomeController',]
    );
    }
     /**
     * @Route("/export-database", name="export_database")
     */
     public function exportDataBaseAction(TranslatorInterface $translator)
     {
        $db = 'magasin';
        $user = 'root';
        $mysqlHostName= 'localhost';
        $mysqlExportPath = 'C:\filesSQL\magasin_export.sql';

        if (file_exists($mysqlExportPath))
            unlink($mysqlExportPath);

        // exec("mysqldump -u$user $db > $mysqlExportPath", $output, $worked);
       
        $q='mysqldump --user='.$user.' '.$db.'>'.$mysqlExportPath;

        //  exec($q, $output, $worked);

        $response = [
            'status' => 'danger',
            'msg' => $translator->trans("Une erreur est produite lors de l' exportation") 
        ];
        $process= new Process($q);
        $process->setWorkingDirectory('C:\wamp64\bin\mysql\mysql8.0.18\bin');
             $process->run();
             if (!$process->isSuccessful())
             {
                 throw new ProcessFailedException($process);

                $response = [
                    'status' => 'danger',
                    'msg' => $translator->trans("Une erreur est produite lors de l' exportation") 
                ];
                }
             else {
                $response = [
                    'status' => 'success',
                    'msg' => $translator->trans("l'operation est terminée avec succés")  
                ];
         }
         echo $process->getOutput();
          return new JsonResponse($response);  
          
     }
 
     /**
      * @Route("/import-database", name="import_database")
      */
     public function importDataBaseAction(TranslatorInterface $translator)
     {
          $target_dir = "C:\\filesSQL";
         $mysqlImportFilename = $target_dir . basename($_FILES["fileSQL"]["name"]);
         $imageFileType = strtolower(pathinfo($mysqlImportFilename, PATHINFO_EXTENSION));
 
         
        if (file_exists($mysqlImportFilename))
             unlink($mysqlImportFilename);
 
         if ($imageFileType != "sql")
             return new JsonResponse([
                 'status' => 'danger',
                 'msg' => $translator->trans("Désolé, seuls les fichiers SQL sont autorisés")
             ]);

         if (!move_uploaded_file($_FILES["fileSQL"]["tmp_name"], $mysqlImportFilename))
             return new JsonResponse([
                 'status' => 'danger',
                 'msg' => $translator->trans("Une erreur est produite lors de l importation")
             ]);

         else {
             return new JsonResponse([
                 'status' => 'success',
                 'msg' => $translator->trans("L'importation de votre fichier est terminée avec succes.")
             ]);
        }
 
        $target_dir = 'C:\\filesSQL\\';
        $mysqlImportFilename = $target_dir . basename($_FILES["fileSQL"]["name"]);
        $imageFileType = strtolower(pathinfo($mysqlImportFilename, PATHINFO_EXTENSION));

        $user = 'root';

         $mysqlDatabaseName = 'magasin';
         $mysqlUserName = 'root';
         $mysqlImportFilename = realpath($mysqlImportFilename);
  
         $q='mysql --user='.$user.' '.$mysqlDatabaseName.'<'.$mysqlImportFilename;
        //  exec($q, $output, $worked);
       
        $process= new Process($q);
         $process->setWorkingDirectory('C:\wamp64\bin\mysql\mysql8.0.18\bin');
             $process->run();

         $response = [
             'status' => 'danger',
             'msg' => $translator->trans("Une erreur est produite lors de l importation")
            
         ];
      if ($process->isSuccessful())
        
      {
        $response = [
            'status' => 'success',
            'msg' => $translator->trans("L'importation de votre fichier est terminée avec succes.")
        ];
    }
        
  echo $process->getOutput();
  return new JsonResponse($response); 
}
}
