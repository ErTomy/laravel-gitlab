<?php
    
    
    namespace Ertomy\Gitlab\Models;
    
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Storage;

    use App\Models\User;

    class Deploy extends Model
    {
        const UPDATED_AT = null;

        public $table = 'git_deploys';

        protected $fillable = [
            'user_id', 
            'created_at', 
            'commit'
        ];

        public function user()
        {
            return $this->belongsTo(User::class);        
        }


        public function getCreatedAtAttribute($date)
        {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y  H:i:s');
        }



        public function getLastCommit(){
            $url = config('gitdeploy.base_url').config('gitdeploy.repository').'/repository/commits/'.config('gitdeploy.branch');

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'PRIVATE-TOKEN' => config('gitdeploy.token')
            ])->get($url)->json();

            return $response['id'];
        }


        public function getAllFiles(){
            $page = 0;     
            $files = [];        
            do {
                $page++;
                $url = config('gitdeploy.base_url').config('gitdeploy.repository').'/repository/tree?per_page=100&page='.$page.'&recursive=true&ref='.config('gitdeploy.branch');
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'PRIVATE-TOKEN' => config('gitdeploy.token')
                ])->get($url)->json();               
                $files = array_merge($files, $response);
            } while ( count($response) !== 0);
            $files = array_values(array_filter($files, function($item){ return $item['type'] == 'blob' ;})); // solo sacamos los ficheros, no las carpetas
            return array_map(function ($item) { return ['path'=>$item['path'], 'status'=>'create']; }, $files);    
        }


        public function getFilesFromCommit($commit, $last_commit){             

            $url = config('gitdeploy.base_url').config('gitdeploy.repository').'/repository/compare?from='.$commit.'&to='.$last_commit.'&straight=false';
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'PRIVATE-TOKEN' => config('gitdeploy.token')
            ])->get($url)->json();   

            return array_map(function ($item) { return ['path'=>$item['new_path'], 'status'=>($item['new_file'])?'create': (($item['deleted_file'])?'delete':'update')]; }, $response['diffs']);
        
        }


        public function downloadFile($file){
            
            $directory = dirname(base_path($file));
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);        
            }

            $url = config('gitdeploy.base_url').config('gitdeploy.repository').'/repository/files/'.urlencode($file).'/raw?ref='.config('gitdeploy.branch');            
            $response = Http::withHeaders([
                'accept' => 'application/octet-stream',
                'PRIVATE-TOKEN' => config('gitdeploy.token')
            ])->sink(base_path($file))->get($url);

            return $response->status() == 200 ? true : false;    
        }

        


    }
