<?php
$foto = $this->session->userdata('foto');
$hak = $this->session->userdata('hak');
if ($foto == NULL || $foto == "") {
  $foto = base_url() . 'aset/img/user.png';
} else {
  $foto = base_url() . $foto;
}

?>
<div class="profil bg-sidebar-merah">
  <div class="border-profil img-bulat"> <a class="tombol-profil" href="<?php echo base_url('akun') ?>"> <img id="side-foto" class="img-fluid" src="<?php echo $foto; ?>" alt="Logo">
      <div class="mask-akun"> <img src="<?php echo base_url(); ?>aset/img/ic_search.png"> </div>
    </a> </div>
  <div class="info-user">
    <h3 id="side-nama"> <?php echo $this->session->userdata('nama') ?> </h3>
    <p id="side-email"><i> <?php echo $this->session->userdata('email') ?></i> </p>
  </div>
</div>
<ul class="app-menu">
  <li>
    <a id="home" class="app-menu__item" href="<?php echo base_url(); ?>">
      <i class="app-menu__icon fa-solid fa-house"></i><span class="app-menu__label">Home</span>
    </a>
  </li>



  <?php if ($hak < 3) { ?>
    <li class="treeview"> <a id="kelompok" class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-cogs">
        </i>
        <span class="app-menu__label">Kelompok Nelayan</span>
        <i class="treeview-indicator fa fa-angle-right">
        </i>
      </a>

      <ul class="treeview-menu">
        <li>
          <a class="treeview-item" href="<?php echo base_url(); ?>kelompok_nelayan">
            <i class="icon fa fa-circle-o"></i>Add Kelompok Nelayan</a>
        </li>
        <li>
          <a class="treeview-item" href="<?php echo base_url(); ?>rapat_bulanan">
            <i class="icon fa fa-circle-o">
            </i>Add Rapat Bulanan
          </a>
        </li>
      </ul>
    </li>

  <?php } ?>
  <!-- yoshe edit ini yaaa yg rapat bulanan buat tanda kalo eror -->
  <!-- <li>
    <a id="rapat_bulanan" class="app-menu__item" href="<?php echo base_url(); ?>rapat_bulanan">
      <i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Rapat Bulanan</span>
    </a>
  </li> -->


  <?php if ($hak < 3) { ?>
    <li>
      <a id="perahu" class="app-menu__item" href="<?php echo base_url(); ?>perahu">
        <i class="app-menu__icon fa fa-list-alt"></i><span class="app-menu__label">Data Perahu</span>
      </a>
    </li>
    <li>
      <a id="nelayan" class="app-menu__item" href="<?php echo base_url(); ?>nelayan">
        <i class="app-menu__icon fa fa-address-book"></i><span class="app-menu__label">Data Nelayan</span>
      </a>
    </li>
  <?php }; ?>

  <?php if ($hak < 3) { ?>
    <li>
      <a id="produksi" class="app-menu__item" href="<?php echo base_url(); ?>produksi">
        <i class="app-menu__icon fa fa-calculator"></i><span class="app-menu__label">Produksi</span>
      </a>
    </li>

    <li>
      <a id="bbm" class="app-menu__item" href="<?php echo base_url(); ?>konsumsi_bbm">
        <i class="app-menu__icon fa fa-thermometer-full"></i><span class="app-menu__label">Konsumsi BBM</span>
      </a>
    </li>

  <?php } ?>
  <!-- <li>
    <a id="coba" class="app-menu__item" href="<?php echo base_url(); ?>coba">
      <i class="app-menu__icon fa fa-user-secret"></i><span class="app-menu__label">Coba</span>
    </a>
  </li> -->
  <li>
    <a id="user" class="app-menu__item" href="<?php echo base_url(); ?>user_management">
      <i class="app-menu__icon fa fa-user-secret"></i><span class="app-menu__label">Account Management</span>
    </a>
  </li>

  <?php if ($hak < 3) { ?>
    <li class="treeview"> <a id="settings" class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-cogs">
        </i>
        <span class="app-menu__label">Systems</span>
        <i class="treeview-indicator fa fa-angle-right">
        </i>
      </a>

      <ul class="treeview-menu">
        <li>
          <a class="treeview-item" href="<?php echo base_url(); ?>metode_tangkap">
            <i class="icon fa fa-circle-o"></i>Add Metode Tangkap</a>
        </li>
        <li>
          <a class="treeview-item" href="<?php echo base_url(); ?>ikan">
            <i class="icon fa fa-circle-o">
            </i>Add Nama Ikan
          </a>
        </li>
        <li>
          <a class="treeview-item" href="<?php echo base_url(); ?>tempat_lelang">
            <i class="icon fa fa-circle-o"></i>Add Tempat Lelang
          </a>
        </li>

        <li>
          <a class="treeview-item" href="<?php echo base_url(); ?>pengepul">
            <i class="icon fa fa-circle-o">
            </i>Add Pengepul
          </a>
        </li>

        <li>
          <a class="treeview-item" href="<?php echo base_url(); ?>banner">
            <i class="icon fa fa-circle-o">
            </i>Banner
          </a>
        </li>
      </ul>
    </li>

  <?php } ?>
  <li>
    <a id="pengaturan" class="app-menu__item" href="<?php echo base_url(); ?>akun">
      <i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Pengaturan Akun</span>
    </a>
  </li>

  <li>
    <a id="lg" class="app-menu__item" href="<?php echo base_url(); ?>login/logout">
      <i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Logout</span>
    </a>
  </li>

  <div class="nginsorbar"></div>
</ul>