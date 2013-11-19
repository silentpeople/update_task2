<?php

class Siswa extends CI_Controller
{
	private $limit=10;
	
	function __construct()
	{
		parent::__construct();
		//loadkn library n helper yg perlu
		$this->load->library(array('table','form_validation'));
		$this->load->helper(array('form','url'));
		$this->load->model('siswa_model','',TRUE);
		
	}
	
	function index($offset=0, $order_column='id', $order_type='asc')
	{
		//periksa utk kolum yg sah
		if (empty($offset)) $offset-0;
		if (empty($order_column)) $order_column='id';
		if (empty($order_type)) $order_type='asc';
		
		
		//data siswa
		$siswas=$this->siswa_model->get_paged_list($this->limit, $offset, $order_column, $order_type)->result();
		
		//utk pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('siswa_model');
		$config['total_rows'] = $this->siswa_model->count_all();
		$config['per_page'] = $this->limit;
		$config['url_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		//utk table data
		$this->load->library('table_name');
		$this->table->set_empty('&nbsp');
		$new_order = ($order_type=='asc'?'desc':'asc');
		$this->table->set_heading('No',
		anchor('siswa/index/'.$offset.'/nama/'.$new_order,'Nama'),
		anchor('siswa/index/'.$offset.'/alamat/'.$new_order,'Alamat'),
		anchor('siswa/index/'.$offset.'/gender/'.$new_order,'Gender'),
		anchor('siswa/index/'.$offset.'/lahir/'.$new_order,'Lahir(dd-mm-yyyy)'),
		'Actions');
		
		$i=0+$offset;
		foreach ($siswas as $siswa)
		{
			$this->table->add_row(++$i,
			$siswa->nama,
			$siswa->alamat,
			strtoupper($siswa->gender)=='M'?
			'Lelaki' : 'Perempuan',
			date ('d-m-Y' , strtotime($siswa_lahir)),
			anchor ('siswa/view'.$siswa_id,'view', array('class'=>'view')).' '.
			anchor ('siswa/update'.$siswa_id,'update', array('class'=>'update')).''.
			anchor ('siswa/delete'.$siswa_id,'delete', array('class'=>'delete','onclick'=>"return confirm('Betul nk hapuskan data?')"))
			);
	     }
		 
		 $data['table']=$this->table->generate();
		 
		 if ($this->uri->segment(3) =='delete_success')
		 	$data['message'] = 'Data berjaya di padamkan';
			
		else if ($this->uri->segment(3) =='add_success')
			$data['message'] = 'Data berjaya di tambah';
		
		else
			$data['message'] = '';
			//load view
			$this->load->view('siswaList',$data);
	}
			 
			 function add()
			 {
				 //set properties
				 $data['title']='Tambah siswa baru';
				 $data['action']= site_url('siswa/add');
				 $data['link_back']= anchor('siswa/index','Kembali ke senarai siswa',
				 array('class'=>'back'));
				 
				 $this->_set_rules();
				 
				 //for validation
				 if ($this->form_validation->run() ===FALSE)
				 {
					 $data['message']='';
					 //set properties
					 $data['title']='Tambah Siswa Baru';
					 $data['message']='';
					 $data['siswa']['id']='';
					 $data['siswa']['nama']='';
					 $data['siswa']['alamat']='';
					 $data['siswa']['gender']='';
					 $data['siswa']['lahir']='';
					 $data['link_back']= anchor('siswa/index/','Lihat Daftar Siswa',
					 array('class'=>'back'));
					 
					 $this->load->view('siswaEdit',$data);
				 }
			 		else
					 {
						 //simpan data
						 $siswa= array('nama'=>$this->input->post('nama'),
						 			   'alamat'=>$this->input->post('alamat'),
									   'gender'=>$this->input->post('gender'),
									   'lahir'=>date('Y-m-d',strtotime($this->input->post('lahir'))));
									   $id=$this->siswa_model->save($siswa);
									   
									   //set input form 
									   $this->validation->id =$id;
									   redirect('siswa/index/add_success');
				    }			
			 }
			 
			 function view($id)
			 {
				 //set properties
				 $data['title']='Siswa Details';
				 $data['link_back']= anchor('siswa/index/','Lihat daftar siswa',
				 array('class'=>'back'));
				 
				 //get siswa detail
				 $data['siswa']=$this->siswa_model->get_by_id($id)->rows();
				 
				 //load view
				 $this->load->view('siswaView',$data);
				 
			 }
			 
			 function update($id)
			 {
				 //set properties
				 $data['title']='Update siswa';
				 $this->load->library('form_validation');
				 
				 //set validation properties
				 $this->_set_rules();
				 $data['action']=('siswa/update/'.$id);
				 
				 //run validation
				 if ($this->form_validation->run() ===FALSE)
				 {
					 $data['message']='';
					 $data['siswa']=$this->siswa_model->get_by_id($id)>row_array();
					 $_POST['gender']=strtoupper($data['siswa']['gender']);
					 $data['siswa']['lahir']= date ('d-m-Y',strtotime($data['siswa']['lahir']));
					 
					 //set properties
					 $data['title']='Update siswa';
					 $data['message']='';
				 }
				 
				 else
				 
				 {
					 //save data
					 $id=$this->input->post('id');
					 $siswa= array('nama'=>$this->input->post('nama'),
					 			 'alamat'=>$this->input->post('alamat'),
								 'gender'=>$this->input->post('gender'),
								 'lahir'=> date('Y-m-d',strtotime($this->input->post('lahir'))));
								 $this->siswa_model->update($id,$siswa);
								 $data['siswa']=$this->siswa_model->get_by_id($id)
								 ->row_array();
								 
								 //set message
								 $data['message']='update siswa berjaya';
				 }
				 $data['link_back']=anchor('siswa/index/','Lihat daftar siswa',array
				 ('class'=>'back'));
				 
				 //load view
				 $this->load->view('siswaEdit',$data);
			 
			 }
			 
			 function delete($id)
			 {
				 //delete siswa
				 $this->siswa_model->delete($id);
				 //redirect to siswa list page
				 redirect('siswa/index/delete_success','refresh');
			 }
			 
			 //validation rule
			 function _set_rules()
			 {
				 $this->form_validation->set_rules('nama','Nama','required|trim');
				 $this->form_validation->set_rules('gender','Gender','required|trim');
				 $this->form_validation->set_rules('alamat','Alamat','required|trim');
				 $this->form_validation->set_rules('lahir','Lahir','required|trim');
			 }
			 
			 //date_validation callback
			 function valid_date($str)
			 { 
			 	if(!preg_match('/^[0-9]{4}-[0-9]{2}[0-9]{2}$/'.$str))
				{
					$this->form_validation->set_message('valid_date','date format is not valid. yyyy-mm-dd');
					return false;
				}
				else
				{
					return true;
				}
			 }
			 
			 
}

	
	
?>
