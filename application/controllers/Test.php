<?php

/**
 * Created by PhpStorm.
 * User: framos
 * Date: 31/7/2017
 * Time: 11:47 AM
 */
use JasperPHP\JasperPHP;
class Test extends CI_Controller
{
    public function index() {
        echo "Hello WorldDD!";
    }
    public function hello() {
//        echo "This is hello function.";
//        $this->load->view('test/test');
        $var = ['pedro','pepe','juan','ariel'];
        echo json_encode($var);
    }
    public function jasper(){
//        $jasper = new \JasperPHP\JasperPHP();
//        var_dump($jasper);
//        \JasperPHP\JasperPHP::process(
//            base_path() . '/vendor/cossou/jasperphp/examples/hello_world.jasper',
//            false,
//            array("pdf", "rtf"),
//            array("php_version" => phpversion())
//        )->execute();
        $reporte = new JasperPHP();
        try {
            /**
             * Construcción de parametros para la generación del reporte
             */
            $input_file = 'C:\xampp\htdocs\validacionDocumental\resources\reports\ListaValidadores.jasper';
            $output_file = 'C:\xampp\htdocs\validacionDocumental\resources\reports\ListaValidadores';
//            $format = $extension;
//            $parameters = $params;
//            $db_connection = config('oracle.oracle');


            $db_connection['hostname'] = '192.168.15.90';
	        $db_connection['username'] = 'postgres';
	        $db_connection['password'] = 'BDpruebas17..';
	        $db_connection['database'] = 'DEJURBEOFICIAL27';
	        $db_connection['driver'] = 'postgres';
            $db_connection['jdbc_dir'] = 'C:\xampp\htdocs\validacionDocumental\resources\JDBCpostgresql/';
            $db_connection['jdbc_driver'] = 'postgresql-42.1.4.jre7.jar';
            $db_connection['db_sid'] = $db_connection['database'];
            $db_connection['host'] = '192.168.15.90';
            $db_connection['port'] = 5432;
            $background = false;
            $redirect_output = false;
            /**
             * Generación de reporte
             */
//            var_dump($reporte);
            $reporte->process($input_file, $output_file, ['pdf'], null, $db_connection, $background, $redirect_output);
            $reporte->execute();
//            var_dump($reporte->output());
            flush();
            /**
             * Se construye un array de objetos con las rutas y enlaces de los archivos generados
             */
            $archivo = [];
            foreach (['pdf'] as $ext) {
                $item = new \stdClass();
                $item->ruta = base_url().'archivo' . '.' . $ext;
//                $item->enlace = config('app.url') . DIRECTORY_SEPARATOR . $directorio . DIRECTORY_SEPARATOR . $nombre_archivo . '.' . $ext;
                array_push($archivo, $item);
            }
//            return $archivo;
//            dd($reporte->output());
        } catch (\Exception $e) {
            flush();
//            dd($reporte->output());
            return false;
        }
//        ejemplo ok
//        C:\xampp\htdocs\validacionDocumental\vendor\cossou\jasperphp\src\JasperPHP/../JasperStarter/bin/jasperstarter process C:\xampp\htdocs\validacionDocumental\resources\reports\ListaValidadores.jasper -o C:\xampp\htdocs\validacionDocumental\resources\reports\ListaValidadores -f pdf -r C:\xampp\htdocs\validacionDocumental\vendor\cossou\jasperphp\src\JasperPHP/../../../../../ -t postgres -u postgres -p BDpruebas17.. -H 192.168.15.90 -n DEJURBEOFICIAL27 --db-port 5432 --db-driver postgresql-42.1.4.jre7.jar --jdbc-dir C:\xampp\htdocs\validacionDocumental\resources\JDBCpostgresql/ --db-sid DEJURBEOFICIAL27
    }
    public function crearReporte($archivo_jasper, $archivo_salida, array $extension = ['pdf'], array $parametros = [])
    {
        $archivo_jasper = trim($archivo_jasper, DIRECTORY_SEPARATOR);
        $archivo_salida = trim($archivo_salida, DIRECTORY_SEPARATOR);
        $archivo_array = explode(DIRECTORY_SEPARATOR, $archivo_salida);
        $nombre_archivo = array_pop($archivo_array);
        $directorio = 'reportes' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $archivo_array);
        if (!is_dir(public_path() . DIRECTORY_SEPARATOR . $directorio)) {
            mkdir(public_path() . DIRECTORY_SEPARATOR . $directorio, 0777, true);
        }
        /**
         * Validación de parametros
         */
        $params = [];
        foreach ($parametros as $key => $value) {
            if (is_null($value)) {
                $params[$key] = '""';
            } elseif (is_string($value)) {
                $params[$key] = '"' . trim($value, "\t\n\r\0\x0B\x27\x22") . '"';
            } else {
                $params[$key] = $value;
            }
        }
        /**
         * Proceso de generación de reportes
         */
        $reporte = new JasperPHP();
        try {
            /**
             * Construcción de parametros para la generación del reporte
             */
            $input_file = base_path('resources' . DIRECTORY_SEPARATOR . 'reports') . DIRECTORY_SEPARATOR . $archivo_jasper;
            $output_file = public_path($directorio) . DIRECTORY_SEPARATOR . $nombre_archivo;
            $format = $extension;
            $parameters = $params;
            $db_connection = config('oracle.oracle');
            $db_connection['jdbc_dir'] = base_path('database' . DIRECTORY_SEPARATOR . 'drivers');
            $db_connection['jdbc_driver'] = 'ojdbc7.jar';
            $db_connection['db_sid'] = $db_connection['database'];
            $background = false;
            $redirect_output = false;
            /**
             * Generación de reporte
             */
            $reporte->process($input_file, $output_file, $format, $parameters, $db_connection, $background, $redirect_output);
            $reporte->execute();
            flush();
            /**
             * Se construye un array de objetos con las rutas y enlaces de los archivos generados
             */
            $archivo = [];
            foreach ($extension as $ext) {
                $item = new \stdClass();
                $item->ruta = public_path($directorio) . DIRECTORY_SEPARATOR . $nombre_archivo . '.' . $ext;
                $item->enlace = config('app.url') . DIRECTORY_SEPARATOR . $directorio . DIRECTORY_SEPARATOR . $nombre_archivo . '.' . $ext;
                array_push($archivo, $item);
            }
            return $archivo;
        } catch (\Exception $e) {
            flush();
            dd($reporte->output());
            return false;
        }

    }
    public function llenarDatos(){
        $id = $this->input->post("idfuncionario");
        var_dump($id);
        if($id != null) {
//                        header('Content-Type: application/json');
//            echo json_encode($data);
            echo 'sssssssssss';
        }
        echo 9;
    }
}