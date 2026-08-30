<?php
// This file is part of Moodle - http://moodle.org
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://gnu.org>.

/**
 * Kaltura language file.
 *
 * @package    local_kaltura
 * @author     Remote-Learner.net Inc
 * @license    http://gnu.org GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://remote-learner.net
 */

$string['admin_secret'] = 'Admin secret';
$string['admin_secret_desc'] = 'Inserisci l\'admin secret per il tuo account.';
$string['cancelbtn'] = 'Annulla';
$string['categories_created'] = 'Numero di categorie create:';
$string['data'] = 'Dati (JSON)';
$string['delete_logs'] = 'Svuota tutti i log';
$string['download_logs_title'] = 'Scarica i log';
$string['download_log_range'] = 'Scarica i log più recenti rispetto alla data selezionata';
$string['endpoint'] = 'Endpoint';
$string['entries_migrated'] = 'Numero di elementi migrati:';
$string['insertbtn'] = 'Incorpora media';
$string['invalid_url'] = 'URL non valido';
$string['kaf_configuration_hdr'] = 'Configurazione KAF';
$string['kaf_uri'] = 'URI KAF';
$string['kaf_uri_desc'] = 'Inserisci l\'URI del server della tua istanza KAF.';
$string['kaltura_course_reports'] = 'Report dei media del corso Kaltura';
$string['kaltura:download_trace_logs'] = 'Scarica i log di tracciamento di Kaltura';
$string['kaltura:migrate_data'] = 'Migra i dati di Kaltura';
$string['migration_cannot_connect'] = 'Errore durante la connessione a Kaltura.';
$string['migration_complete_redirect'] = 'La migrazione è stata completata.';
$string['migration_has_stopped'] = 'A causa della grande quantità di dati, è stata completata solo una parte della migrazione. L\'ultima posizione nota è stata salvata ed è possibile continuare la migrazione dei dati.';
$string['migration_header'] = 'Migrazione dei dati';
$string['migration_kaf_url_not_set'] = 'L\'URI KAF non è impostato. Inserisci un URI KAF prima di avviare la migrazione';
$string['migration_not_started'] = 'Fai clic sul pulsante avvia/continua per iniziare la migrazione.';
$string['migration_notice'] = 'I dati del tuo account devono essere migrati per poter essere utilizzati con questa versione dei plugin. Vai alla <a href="{$a}">pagina di migrazione</a> per avviare il processo.';
$string['migration_root_category_not_set'] = 'Impossibile determinare l\'ID della categoria radice (root).';
$string['migration_profile_id_not_set'] = 'Impossibile determinare l\'ID del profilo dei metadati.';
$string['migration_select_a_category'] = 'Seleziona una categoria KAF verso cui migrare';
$string['migration_start_continue'] = 'Avvia / Continua';
$string['migration_start_over_redirect'] = 'Le statistiche di migrazione e l\'ultima posizione nota sono state reimpostate.';
$string['migration_start_time'] = 'La migrazione è stata originariamente avviata il:';
$string['missing_required_info'] = 'Attenzione: l\'ID del Partner o l\'Admin secret sono vuoti. I plugin di Kaltura non funzioneranno.';
$string['module'] = 'Modulo';
$string['no_records'] = 'Nessun record restituito.';
$string['original_kafcategory'] = 'La categoria KAF selezionata per la migrazione.';
$string['partner_id'] = 'Partner ID';
$string['partner_id_desc'] = 'Inserisci id partner per il tuo account.';
$string['pluginname'] = 'Librerie del pacchetto Kaltura';
$string['preview'] = 'Anteprima';
$string['records_deleted'] = 'Tutti i record dei log di Kaltura sono stati eliminati.';
$string['request'] = 'Richiesta/Risposta';
$string['server_uri'] = 'URI del Server';
$string['server_uri_desc'] = 'Inserisci l\'URI del server a cui desideri connetterti. In alternativa, lascia le impostazioni predefinite (questa impostazione viene utilizzata per scopi di migrazione).';
$string['startover'] = 'Riavvia la migrazione';
$string['time'] = 'Ora';
$string['trace_log'] = 'Abilita i log di tracciamento';
$string['trace_log_desc'] = 'Se abilitato, tutte le richieste e le risposte da e verso Kaltura verranno registrate nei log. Questi log possono essere utilizzati dal supporto di Kaltura per diagnosticare eventuali problemi riscontrati. L\'abilitazione di questa impostazione potrebbe influire sulle prestazioni di Moodle. Puoi scaricare un file CSV dei log da <a href="{$a}">qui</a>.';
$string['browse_and_embed'] = 'Sfoglia e Incorpora';
$string['enable_submission'] = 'Clona le consegne';
$string['enable_submission_desc'] = 'Se abilitato, qualsiasi contenuto multimediale inviato tramite il flusso di consegna video di Kaltura verrà clonato con un nome utente diverso per impedirne la modifica e l\'eliminazione.';
$string['privacy:metadata:courseid'] = 'L\'ID del corso da cui l\'utente sta accedendo al Consumer LTI';
$string['privacy:metadata:courseidnumber'] = 'Il codice identificativo (ID number) del corso da cui l\'utente sta accedendo al Consumer LTI';
$string['privacy:metadata:coursefullname'] = 'Il nome completo del corso da cui l\'utente sta accedendo al Consumer LTI';
$string['privacy:metadata:courseshortname'] = 'Il nome abbreviato del corso da cui l\'utente sta accedendo al Consumer LTI';
$string['privacy:metadata:email'] = 'L\'indirizzo email dell\'utente che accede al Consumer LTI';
$string['privacy:metadata:externalpurpose'] = 'Il Consumer LTI fornisce informazioni sull\'utente e sul contesto al Provider dello strumento LTI.';
$string['privacy:metadata:firstname'] = 'Il nome dell\'utente che accede al Consumer LTI';
$string['privacy:metadata:fullname'] = 'Il nome completo dell\'utente che accede al Consumer LTI';
$string['privacy:metadata:lastname'] = 'Il cognome dell\'utente che accede al Consumer LTI';
$string['privacy:metadata:role'] = 'Il ruolo nel corso dell\'utente che accede al Consumer LTI';
$string['privacy:metadata:userid'] = 'L\'ID dell\'utente che accede al Consumer LTI';
$string['privacy:metadata:useridnumber'] = 'Il codice identificativo (ID number) dell\'utente che accede al Consumer LTI';
$string['privacy:metadata:username'] = 'Il nome utente dell\'utente che accede al Consumer LTI';
$string['privacy:metadata:editor'] = 'L\'editor dell\'utente che accede al Consumer LTI';
$string['privacy:metadata:module'] = 'Il nome del modulo da cui l\'utente sta accedendo al Consumer LTI';
$string['privacy:metadata:source'] = 'L\'URL sorgente dell\'elemento multimediale dell\'utente che accede al Consumer LTI';
$string['privacy:metadata:custompublishdata'] = 'I corsi a cui l\'utente è iscritto e i ruoli LTI che l\'utente ha nel corso';
$string['lti_version'] = 'Versione LTI';
$string['lti_version_desc'] = 'Scegli con quale versione LTI deve funzionare l\'account';
$string['lti1p1'] = 'LTI1.1';
$string['lti1p3'] = 'LTI1.3';
$string['public_keyset_url'] = 'URL del Keyset pubblico';
$string['public_keyset_desc'] = 'URL del Keyset pubblico';
$string['launch_url'] = 'URL di avvio (Launch URL)';
$string['launch_url_desc'] = 'URL di avvio (Launch URL)';
$string['client_id'] = 'ID Client';
$string['client_id_desc'] = 'ID Client';
$string['redirection_uris'] = 'URI di reindirizzamento';
$string['redirection_uris_desc'] = 'URI di reindirizzamento';
$string['guest_support'] = 'Supporto ospiti';
$string['guest_support_desc'] = "Se abilitato, utilizza la funzionalità di Moodle per identificare gli ospiti e gli utenti non autenticati, assegnando loro il ruolo LTI 'Guest'.";
