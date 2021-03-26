<?php
/**
 * Gestion des frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Mike Vielfaure
 * @copyright 2021
 * @license   Réseau CERTA
 * @version   GIT: <0>
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'listeFicheFrais':
    $fichesFrais = $pdo->getFichesFrais("VA");
    if($fichesFrais != null){
    include 'vues/v_listeFicheFrais.php';
    }else{
      include 'vues/v_noFicheFraisVA.php';  
    }
    break;
case 'detailFicheFrais':
    $fichesFrais = $pdo->getFichesFrais("VA");
    include 'vues/v_listeFicheFrais.php';
    $leMois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_STRING);
    $leVisiteurId = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_STRING);
    $_SESSION['moisSession'] = $leMois;
    $_SESSION['idVisiteurSession'] = $leVisiteurId;
    $unVisiteur = $pdo->getNomPrenomVisiteur($leVisiteurId);
    $leNom = $unVisiteur['nom'];
    $lePrenom = $unVisiteur['prenom'];
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteurId, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($leVisiteurId, $leMois);
    include 'vues/v_detailFicheFrais.php';
    break;
case 'paiement':
    $leVisiteurId = $_SESSION['idVisiteurSession'];
    $leMois = $_SESSION['moisSession'];
    $pdo->majFiche($leVisiteurId, $leMois, "RB");
    include 'vues/v_paiementValide.php';
    break;
}

