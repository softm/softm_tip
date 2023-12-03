<?

/*

################################################################

Filename: htmldoc.class.php
Version: 0.1c
Author: Tom Arnold (ta@alea-active.com)
lastchange: 2002/10/04 04:34 am

Copyright: (c) 2002, alea active GmbH, Weinheim, Germany, http://www.alea-active.com

################################################################
Description:
Object Library for Creation of PDF Documents out of HTML Pages
by using htmldoc as conversion facility.(more features to be added in the future)

Requires:
- Compiled and installed htmldoc tool, available at
   http://www.easysw.com/htmldoc/
- Current working directory writable by webserver for creating
   a temporary error html file if this class fails

Configuration:
Make sure to set the HTMLDOCPATH constant to your location of
the htmldoc software, or this class will fail.
   
Parameters:
Parameters are supplied as second argument for the constructor
The Parameters separator is the "|" sign. Assignment of values
to parameters are done via the "=" sign.

Example: html2pdf_doc("http://www.google.de","header=./.");
This would set the header parameter to ./.

Valid Parameters:

header
Sets the page header, see htmldoc documentation for 
available options. The default is "..."
		 
footer  
Like header but sets the page footer

page_format
Sets the size of the resulting pdf page. 
Valid values are: a4, letter
Example: page_format=a4

margins=l,r,t,b
Sets the page margins in mm
Example: margins=10,10,10,10

lmargin / rmargin / tmargin / bmargin
Sets the corresponding margin in mm
Example: rmargin=10 		


################################################################

*/

// Configuration Constants
define("HTMLDOCPATH","/usr/bin/htmldoc");	// Change this to your htmldoc path


define("HTMLDOCDEBUGON","1");
define("HTMLDOCDEBUGOFF","0");

class htmldoc
{

	// Class and Configuration Variables
	
	var $debug = HTMLDOCDEBUGOFF;	// Whether debugging should be ON or OFF
	var $unparsed_Parameters; // the unparsed parameter string
	var $error = false;	// initialize the error flag
	var $errorlist = Array();	// intitialize the error array
	var $data;	// to store the generated pdf data
	var $pdf_filename = "generic.pdf";	// the filename for the inline created page
	var $page_format;	// the size of the page
	var $html_doc;	// the input html document
	var $pheader;	// the pheader format string
	var $pfooter;	// the pfooter format string
	var $lmargin;	// the left margin of the pages
	var $rmargin;	// the right margin of the pages
	var $tmargin;	// the top margin of the pages
	var $bmargin;	// the bottom margin of the pages

//###############################################################################
	// Constructor

	function html2pdf_doc($htmlfile = "", $parameters = "", $htmldoc_path=HTMLDOCPATH)
	{
		$this->debugger("Creating new html2pdf_doc object ...");
		if (trim($htmlfile) <> "")
		{
			$this->set_html_document($htmlfile);
			$this->parse_parameters($parameters);
		} else {
			$this->pdf_error("<B>ERROR:</B> No input html document set<BR>");
		}

	}
//###############################################################################
	function parse_parameters($parameters)
	{
		$this->debugger("Parsing parameters ...");	
		// Check wheter we have parameters to set, else set default parameters
		if (trim($parameters) == "") 
		{
			$this->set_default_parameters();
		} else {
			$this->set_default_parameters();		
			$parameters2parse = explode("|",$parameters);
			foreach($parameters2parse as $parameter2parse)
			{
				$this->set_and_check_parameter($parameter2parse);
			}
		}
	}
//###############################################################################	
	function set_default_parameters()
	{
	
		// Here, the default parameters have to be specified
	
		$this->debugger("Setting default parameters ...");
		$this->page_format = "a4";
		$this->pheader = "--header ...";
		$this->pfooter = "--footer ...";
		$this->lmargin = "--left 10mm";
		$this->rmargin = "--right 10mm";
		$this->tmargin = "--top 10mm";
		$this->bmargin = "--bottom 10mm";						
	}	
//###############################################################################	
	function set_and_check_parameter($parameter)
	{
	
		// Handles setting and checking of parameters passed to the constructor of the class
	
		$this->debugger("Setting and checking parameter $parameter ...");
		list($p,$value) = explode("=",$parameter);
		switch($p)
		{
			case "page_format":
				$this->set_page_format($value);
				break;
			case "header":
				$this->set_pheader($value);
				break;
			case "footer":
				$this->set_pfooter($value);
				break;
			case "margins":
				$this->set_margins($value);
				break;
			case "lmargin":
				$this->set_lmargin($value);
				break;
			case "rmargin":
				$this->set_rmargin($value);
				break;
			case "tmargin":
				$this->set_tmargin($value);
				break;
			case "bmargin":
				$this->set_bmargin($value);
				break;															
		}	
	}
//###############################################################################
	function set_margins($value = "10,10,10,10")
	{
		// Sets all 4 margins of the page
		// Parameter has to be specified in Millimeters
		// The order is, Left,Right,Top,Bottom
			
		list($l,$r,$t,$b) = explode(",",$value);
		$this->set_lmargin($l);
		$this->set_rmargin($r);
		$this->set_tmargin($t);
		$this->set_bmargin($b);						
	}
//###############################################################################
	function set_lmargin($margin = "10")
	{
		// Sets the left margin of the page
		// Parameter has to be specified in Millimeters	
	
		$this->lmargin = "--left ".$margin."mm";
	}
//###############################################################################
	function set_rmargin($margin = "10")
	{
		// Sets the right margin of the page
		// Parameter has to be specified in Millimeters	
	
		$this->rmargin = "--right ".$margin."mm";
	}
//###############################################################################
	function set_tmargin($margin = "10")
	{
		// Sets the top margin of the page
		// Parameter has to be specified in Millimeters	
	
		$this->tmargin = "--top ".$margin."mm";
	}
//###############################################################################
	function set_bmargin($margin = "10")
	{
		// Sets the bottom margin of the page
		// Parameter has to be specified in Millimeters	
	
		$this->bmargin = "--bottom ".$margin."mm";
	}				
//###############################################################################
	function set_pheader($header = "...")
	{
	
		// Sets the page header

		$this->debugger("Setting Page header to \"$header\" ...");
		if($this->head_foot_syntax_valid($header))
		{
			$this->pheader = "--header $header";
		}
	}
//###############################################################################
	function set_pfooter($footer = "...")
	{
		// Sets the page footer
		
		$this->debugger("Setting Page footer to \"$footer\" ...");
		if($this->head_foot_syntax_valid($footer))
		{		
			$this->pfooter = "--footer $footer";
		}
	}	
//###############################################################################
	function head_foot_syntax_valid($hf)
	{
	
		// This function checks whether the format flags passed in are valid
		// in the context of htmldoc
	
		$returnvalue = true;
		$validchars = "./:1aAcCdDhiIltT";  // Defines the valid characters for the format string
		if(strlen($hf) <> 3)	// The format string must have a length of 3 chars
		{
			$returnvalue = false;
		}
		if (!strstr($validchars,substr($hf,0,1)) || !strstr($validchars,substr($hf,1,1)) || !strstr($validchars,substr($hf,2,1)))
		{
			$returnvalue = false;
		}

		return $returnvalue;
	}	
//###############################################################################	
	function set_page_format($format = "a4")
	{
	
		/*
		
		This function sets the output format of the generated pdf document
		Valid values for format are: a4, letter
		
		*/
	
		switch($format)
		{
			case "a4":
				$this->page_format = "a4"; // Choose a4 as document size
				break;
			case "letter":
				$this->page_format = "letter"; // Choose US Letter Format as document size
				break;
		}
	}
//###############################################################################
	function set_html_document($htmlfile){
	
		// Sets and checks the html input file for validity (valid url or filepath)
	
	    if (strncmp($htmlfile, "http://", 7) != 0 && strncmp($htmlfile, "https://", 8) != 0)   // if the file is not an URL
		{
        	if (file_exists(realpath($htmlfile)))  // Check whether the file exists locally, if it does ...
			{
				$this->html_doc = realpath($htmlfile);  
			} else { // if it doesn't, generate the appropriate error message
				$this->pdf_error("<B>ERROR:</B> The input html document specified either doesn't exist or isn't valid<BR>");
			}
    	} else { // the htmlfile is an url, so just take it without a check
		
			//TO-DO: Add validity check (whether the file exists and is accessible)
		
			$this->html_doc = $htmlfile;
		}
	}
//###############################################################################	
	function generate_pdf()
	{
	
		// This function is responsible for creating the pdf data in memory
		// If there were errors, it will create an error pdf instead.
	
		$this->debugger("Generating and outputing pdf ...");	
		if($this->error) // If there were any errors ...
		{
			$this->generate_error_pdf(); // ... generate the error pdf
		} else { // else generate the pdf document
			$passthru = HTMLDOCPATH." --no-compression -t pdf14 --quiet --jpeg --webpage $this->pheader $this->pfooter --size $this->format $this->lmargin $this->rmargin $this->tmargin $this->bmargin '".$this->html_doc."'";		
			// echo $passthru;
			ob_start();
			passthru($passthru); // generate it
			$this->data = ob_get_contents(); // get the generated data
			ob_end_clean();		
		}
	}
//###############################################################################
	function pdf_error($errortext)
	{
	
		// PDF error handling (Error messages, etc..)
	
		$this->debugger("The error with errortext \"$errortext\" occured ...");	
		$this->error = true;
		array_push($this->errorlist,$errortext);
	}
//###############################################################################
	function generate_error_pdf()
	{
		// Generate the error html file
		$this->debugger("generating and writing error html file ...");	
		$errfile = fopen(realpath("./htmldocerr.htm"),"w") or die("Couldn't write to errorfile");
		$webpath = str_replace("/home/d1/k4b/komm4buy.info/www/","http://www.komm4buy.info/",realpath("./htmldocerr.htm"));
		fwrite($errfile,"<HTML>\n");
		fwrite($errfile,"<BODY>\n");
		foreach($this->errorlist as $currenterror)
		{
			fwrite($errfile,$currenterror."\n");
		}
		fwrite($errfile,"</BODY>\n");
		fwrite($errfile,"<HTML>\n");
		fclose($errfile);
		
		// Convert the error html file to pdf with standard options and output it
		if ($this->debug == HTMLDOCDEBUGON)
		{
			readfile(realpath("./htmldocerr.htm"));
		} else {
			// generate the error pdf
			$passthru = HTMLDOCPATH." --no-compression -t pdf14 --quiet --jpeg --webpage --header t.D --footer ./. --size letter --left 10mm '".realpath("./htmldocerr.htm")."'";			
			// echo $passthru;
			ob_start();
			passthru($passthru);
			$this->data = ob_get_contents();
			ob_end_clean();
		}
	}	
//###############################################################################
	function output_pdf()
	{
			
			// Outputs the pdf data as inline content
	
			header("Content-type: application/pdf");
			header("Content-Disposition: inline; filename=".$this->pdf_filename);
			header('Content-length: ' . strlen($this->data));
			echo $this->data;
	}
//###############################################################################
	function download_pdf()
	{
			// Outputs the pdf data as attachement content

			header("Content-type: application/pdf");
			header("Content-Disposition: attachement; filename=".$this->pdf_filename);
			header('Content-length: ' . strlen($this->data));
			echo $this->data;
	}		
//###############################################################################
	function debugger($debugmessage)
	{
		if ($this->debug == HTMLDOCDEBUGON)
		{
			echo $debugmessage."<BR>";
		}
	
	}
//###############################################################################	
} // End of Class
?>
