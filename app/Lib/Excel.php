<?php

/**
 
 */

class Excel extends Controller
{
    //Main attributes
    /**
     *
     * @var object
     */
    public $excel;
    /**
     *
     * @var string
     */
    public $author;
    /**
     *
     * @var string
     */
    public $title;
    /**
     *
     * @var string
     */
    public $subject;
    /**
     *
     * @var string
     */
    public $description;
    /**
     *
     * @var string
     */
    public $keywords;
    /**
     *
     * @var string
     */
    public $category;
    /**
     *
     * @var array
     */
    public $columns;
    /**
     *
     * @var array
     */
    public $info;

    //Atributes Secundary
    public $requirement;
    public $alpha;
    public function __construct($data = [/**/])
    {
        //Error manager
        try {

            //Instancia de la libraría PHPExcel
            $this->excel = new PHPExcel;
            //Set information file
            $this->author      = $data['author'] ?? $this->fileInfo()['author'];
            $this->title       = $data['title'] ?? $this->fileInfo()['title'];
            $this->subject     = $data['subject'] ?? $this->fileInfo()['subject'];
            $this->description = $data['description'] ?? $this->fileInfo()['description'];
            $this->keywords    = $data['keywords'] ?? $this->fileInfo()['keywords'];
            $this->columns     = $data['columns'] ?? $this->fileInfo()['columns'];

            //If not isset var requirement
            if (!isset($data['requirement'])) :
                //Throw new exceptio for with the message
                throw new Exception("No existe ninguna solicitud para procesar, pruebe con: ", 1);
            elseif (!isset($data['info']) && empty($data['info'])) :
                throw new Exception("No se ha detecatdo indice info, el cual debe contener la matriz de datos", 1);
            else :
                $this->info = $data['info'];
                //Otherwise the request will be processed by the requirements filter
                switch ($data['requirement']) {
                    case 'list':
                        self::listAll();
                        break;

                    default:
                        throw new Exception("El requerimiento solicitado no existe, pruebe con: ", 1);
                        break;
                }
            endif;
        } catch (Exception $e) {
            //Return error view
            return $this->vista('bug', array(
                'titulo'   => 'Upps!',
                'mensaje'  => $e->getMessage(),
                'problema' => 'su solicitud',
            )) . exit();
        }
    }

    /**
     * Default info meta data for files
     *
     * @return array
     */
    public function fileInfo()
    {
        return array(
            'author'      => NOMBRE_APP,
            'title'       => NOMBRE_APP . date("Y-m-d"),
            'subject'     => 'Excel info',
            'description' => '© ' . NOMBRE_APP . ' | ' . date("Y"),
            'keywords'    => 'Informes, listados, graficas',
            'category'    => 'Informes',
            'columns'     => array(),

        );
    }

    /**
     * generate information list
     *
     * @method ListAll()
     */
    public function listAll()
    {

        //Set properties for document
        $this->excel->getProperties()->setCreator($this->author)->setLastModifiedBy($this->author)->setTitle($this->title)->setSubject($this->subject)->setDescription($this->description)->setKeywords($this->keywords)->setCategory($this->category);



        $alpha = 'A';
        for ($ii = 0; $ii < count($this->columns); $ii++) {
            //
            $this->excel->setActiveSheetIndex(0)->setCellValue($alpha . 2, $this->columns[$ii]);
            $this->excel->getActiveSheet()->getColumnDimensionByColumn($ii)->setAutoSize(true);

            $alpha++;
        }
        // Add some data
        $this->excel->setActiveSheetIndex(0)->mergeCells("A1:{$alpha}1");
        $this->excel->getActiveSheet()->setCellValue('A1', $this->author . ' ' . $this->title);
        $this->excel->getActiveSheet()->getStyle('1:2')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->fromArray($this->info, 'N/A', 'A3');

        // Rename worksheet
        $this->excel->getActiveSheet()->setTitle($this->title);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $this->excel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        $file_name = $this->title . "_" . date("Y-m-d");
        header('Content-Disposition: attachment;filename="' . $file_name . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');

        exit;
    }
}
