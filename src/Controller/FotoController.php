<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Foto Controller
 *
 * @property \App\Model\Table\FotoTable $Foto
 */
class FotoController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Foto->find()
            ->contain(['Album', 'Users']);
        $foto = $this->paginate($query);

        $this->set(compact('foto'));
    }

    /**
     * View method
     *
     * @param string|null $id Foto id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $foto = $this->Foto->get($id, contain: ['Album', 'Users', 'Komentar', 'Likes']);
        $data = $this->Foto->Users->find('list')->all();
        $users = $data->toArray();
        $this->set(compact('foto','users'));
        $foto = $this->Foto->get($id, [
            'contain' => ['Likes']
        ]);
    }

    /**
     * Add method
     *s
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $foto = $this->Foto->newEmptyEntity();
        if ($this->request->is('post')) {
            $foto = $this->Foto->patchEntity($foto, $this->request->getData());
            $file = $this->request->getUploadedFiles();

            $foto->lokasi_file = $file ['images']->getClientFilename();
            $file['images']->moveTo(WWW_ROOT . 'img' . DS . 'foto' . DS . $foto->lokasi_file);

            if ($this->Foto->save($foto)) {
                $this->Flash->success(__('The foto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The foto could not be saved. Please, try again.'));
        }
        $users = $this->Foto->Users->find('list', limit: 200)->all();
        $album = $this->Foto->Album->find('list', limit: 200)->all();
        $this->set(compact('foto', 'users', 'album'));

    }

    /**
     * Edit method
     *
     * @param string|null $id Foto id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
    //     $foto = $this->Foto->get($id, contain: []);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $foto = $this->Foto->patchEntity($foto, $this->request->getData());
    //         if ($this->Foto->save($foto)) {
    //             $this->Flash->success(__('The foto has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The foto could not be saved. Please, try again.'));
    //     }
    //     $album = $this->Foto->Album->find('list', limit: 200)->all();
    //     $users = $this->Foto->Users->find('list', limit: 200)->all();
    //     $this->set(compact('foto', 'album', 'users'));
    // }
    public function edit($id = null)
            {
                $foto = $this->Foto->get($id, contain: []);
                if ($this->request->is(['patch', 'post', 'put'])) {
                    $foto = $this->Foto->patchEntity($foto, $this->request->getData());
                    $file = $this->request->getUploadedFiles();//add this line also

                    if(!empty($file['images']->getClientFilename())){ 
                    $foto->lokasi_file = $file['images']->getClientFilename();
                    $file['images']->moveTo(WWW_ROOT . 'img' . DS . 'foto' . DS . $foto->lokasi_file);
                    }
                    if ($this->Foto->save($foto)) {
                        $this->Flash->success(__('The foto has been saved.'));

                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('The foto could not be saved. Please, try again.'));
                }
                $users = $this->Foto->Users->find('list', limit: 200)->all();
                $album = $this->Foto->Album->find('list', limit: 200)->all();
                $this->set(compact('foto', 'users', 'album'));
            }

    /**
     * Delete method
     *
     * @param string|null $id Foto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $foto = $this->Foto->get($id);
        if ($this->Foto->delete($foto)) {
            $this->Flash->success(__('The foto has been deleted.'));
        } else {
            $this->Flash->error(__('The foto could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
