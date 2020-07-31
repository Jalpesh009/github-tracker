<?php
namespace App;

class OwnGitRepository extends \Cz\Git\GitRepository
{
  public function getChanges()
		{
			// Make sure the `git status` gets a refreshed look at the working tree.
			$this->begin()
				->run('git update-index -q --refresh')
				->end();

			$output = $this->extractFromCommand('git status --porcelain');

                        $files = array();

                        if(empty($output)){
                            return $files;
                        }

                        foreach($output as $line){
                            $line = trim($line);

                            $file = explode(" ", $line, 2);
                            if(count($file) >= 2){
                                $files[$file[1]] = $file[0];
                            }
                        }
                        return $files;
		}
}
