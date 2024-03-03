<?php

class RamaisStatus {
    private $ramais;
    private $filas;
    private $status_ramais;

    public function __construct() {
        $this->ramais = file('ramais');
        $this->filas = file('filas');
        $this->status_ramais = $this->getStatusRamais();
    }

    private function getStatusRamais() {
        $status_ramais = array();
        foreach ($this->filas as $linhas) {
            if (strstr($linhas, 'SIP/')) {
                if (strstr($linhas, '(Ring)')) {
                    $linha = explode(' ', trim($linhas));
                    list($tech, $ramal) = explode('/', $linha[0]);
                    $status_ramais[$ramal] = array('status' => 'chamando');
                }
                if (strstr($linhas, '(In use)')) {
                    $linha = explode(' ', trim($linhas));
                    list($tech, $ramal) = explode('/', $linha[0]);
                    $status_ramais[$ramal] = array('status' => 'disponivel');
                }
                if (strstr($linhas, '(Not in use)') || strstr($linhas, '(paused)')) {
                    $linha = explode(' ', trim($linhas));
                    list($tech, $ramal) = explode('/', $linha[0]);
                    $status_ramais[$ramal] = array('status' => 'ocupado');
                }
                if (strstr($linhas, '(Unavailable)')) {
                    $linha = explode(' ', trim($linhas));
                    list($tech, $ramal) = explode('/', $linha[0]);
                    $status_ramais[$ramal] = array('status' => 'indisponivel');
                }
            }
        }
        return $status_ramais;
    }

    public function getInfoRamais() {
        $info_ramais = array();
        foreach ($this->ramais as $linhas) {
            $linha = array_filter(explode(' ', $linhas));
            $arr = array_values($linha);
            if (trim($arr[1]) == '(Unspecified)' && trim($arr[4]) == 'UNKNOWN') {
                list($name, $username) = explode('/', $arr[0]);
                $info_ramais[$name] = array(
                    'nome' => $name,
                    'ramal' => $username,
                    'online' => false,
                    'status' => $this->status_ramais[$name]['status']
                );
            }
            if (trim($arr[5]) == "OK") {
                list($name, $username) = explode('/', $arr[0]);
                $info_ramais[$name] = array(
                    'nome' => $name,
                    'ramal' => $username,
                    'online' => true,
                    'status' => $this->status_ramais[$name]['status']
                );
            }
        }
        return $info_ramais;
    }

    public function outputJSON() {
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($this->getInfoRamais());
    }
}

$ramaisStatus = new RamaisStatus();
$ramaisStatus->outputJSON();
?>