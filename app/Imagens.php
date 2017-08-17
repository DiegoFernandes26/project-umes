<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class Imagens extends Model
{
    /*
     * trata a imagem e guarda na pasta,
     * @return Retorna o camiho da imagem pronto para inserção no banco.
     * param $file = imagem que vem do formulário
     * param $dir NULLO pode ou não passar o caminho da imagem.
     */
    public function createImagem($file, $dir = null)
    {
        if (Input::file()):
            //inicio criação do nome da imagem
            $data = \Carbon\Carbon::now();
            $dt = $data->ToDateString();
            $micro = $data->micro;
            $hora = $data->format('H-i-s-m');
            $dtHora = $hora. '-' . $micro;

            //criando diretório
            if ($dir):
                $diretorio = $dir;
            else:
                $diretorio = 'img/' . $data->year . "/" . $data->month . "/" . $data->day;
            endif;

            //se não existir ele cria o diretorio
            if (!file_exists($diretorio)):
                mkdir($diretorio, 0777, true);
            endif;

            //data e hora servem para nomear a imagem de maneira única, concatenada com a extensão do arquivo.
            $imgName = $dtHora . '.' . $file->getClientOriginalExtension();

            $caminho = $diretorio . '/' . $imgName;
            //salva a imagem redimensionada no caminho indicado.
            $redImagem = Image::make($file->getRealpath());
            $redImagem->resize(null, 1000, function ($constraint) {
                $constraint->aspectRatio();
            });
            $redImagem->save($caminho);
            //$img->destroy();
        endif;
        return $caminho;
    }
}
