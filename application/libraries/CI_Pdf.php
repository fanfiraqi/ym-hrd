<?php
    class CI_Pdf {

    function pdf_create($html, $filename, $stream=TRUE)
    {
		require_once("dompdf/dompdf_config.inc.php");
		spl_autoload_register('DOMPDF_autoload');

		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		if ($stream) {
			$dompdf->stream($filename.".pdf");
		} else {
			$CI =& get_instance();
			$CI->load->helper('file');
			write_file($filename, $dompdf->output());
		}
    }


    function pdf_create_my($html, $filename,$paper, $orientation, $stream=TRUE)
    {
		require_once("dompdf/dompdf_config.inc.php");
		spl_autoload_register('DOMPDF_autoload');

		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper($paper, $orientation);
		$dompdf->render();
		if ($stream) {
			$dompdf->stream($filename.".pdf");
		} else {
			$CI =& get_instance();
			$CI->load->helper('file');
			write_file($filename, $dompdf->output());
		}
    }

	//utk slip save As, tp pending nunggu solusi
	 function pdf_create_report($html, $filename,$paper='a8', $orientation='portrait', $stream=TRUE)
    {
		require_once("dompdf/dompdf_config.inc.php");
		spl_autoload_register('DOMPDF_autoload');

		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper($paper, $orientation);
		$dompdf->render();
		if ($stream) {
			$dompdf->stream($filename.".pdf");
		} else {
			$CI =& get_instance();
			$CI->load->helper('file');
			write_file($filename, $dompdf->output());
		}
    }
}

