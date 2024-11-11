<?php
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . "/vendor/autoload.php");
use Dotenv\Dotenv;

class block_simplecamera extends block_base {
    public function init() {
        $this->title = get_string('simplecamera', 'block_simplecamera');
        $dotenvPath = __DIR__ . '/.env';
        if(file_exists($dotenvPath)) {
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load();
        }
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
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
    }

    public function instance_allow_multiple() {
      return true;
    }

}
