<?php
class block_simplecamera extends block_base {
    public function init() {
        $this->title = get_string('simplecamera', 'block_simplecamera');
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        // $this->content->text = "The content of our SimpleHTML block!<b>Hello</b>";
        $this->content->text = 
"<video id='camera' width='320' height='240' autoplay></video><br/>".
"<canvas id='canvas' width='320' height='240'></canvas>".
"<button id='save_button'>Hazme Click</button><br/>";
        $this->content->footer = "Footer here...";

        $cameraperiod = 10000;
        if (! empty($this->config->period)) {
            $cameraperiod = $this->config->period;
        }

        require_once(__DIR__ . '/../../config.php');
        global $USER;

        $userid = $USER->id;
        $title = $this->page->title;
        $this->page->requires->js_call_amd('block_simplecamera/camera', 'init', [
            $cameraperiod,
            $title,
            $userid
        ]);

        return $this->content;
    }

    public function specialization() {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_simplecamera');            
            } else {
                $this->title = $this->config->title;
            }
        }

        if(!file_exists("./.env")) {

            // $file = fopen("./.env", "w");
            
            $keys = array("aws_public_key", "aws_region", "aws_secret_key", 
            "db_dialect", "db_host", "db_name", "db_password", 
            "db_user", "version");
            
            // Writes the enviorments variables in the file.
            $configs = json_encode(get_config('block_simplecamera'));
            error_log($configs);
            error_log("Televisa presenta");
            // $configs = str_replace(":", " = ", $configs);
            // $configs = str_replace(",", "\n", $configs);
            // $configs = str_replace(array("{", "}", "\""), "", $configs);
            // $configs = str_replace($keys, $this -> array_to_upper($keys), $configs);

            // fwrite($file, $configs);

            // fclose($file);

        }
    }

    public function instance_allow_multiple() {
      return true;
    }

// public function applicable_formats() {
//   return array('site-index' => true);
// }
}
