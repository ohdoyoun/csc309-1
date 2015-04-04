<?php
class WalletsController extends AppController {
    
    public $name = 'Wallets';
    
    public function beforeFilter() {
        parent::beforeFilter(); 
        if (!($this->Auth->user())) {
            $this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
        }
        
    }
    
    public function index() {
        $this->set('wallet', $this->Wallet->query('SELECT update_date, funds, name as description FROM wallets, wallet_transactions, payment_methods where wallets.id=wallet_transactions.wallet_id and wallets.payment_method_id=payment_methods.id and wallets.user_id=' . $this->Auth->user('id') . ' ORDER BY update_date DESC;'));
        $this->set('total', $this->Wallet->query('SELECT sum(total) as total FROM (SELECT sum(funds) as total, user_id FROM wallets, wallet_transactions where wallet_id=wallets.id and user_id=' . $this->Auth->user('id') . ' GROUP BY user_id UNION SELECT sum(funds) * -1 as total, user_id FROM transactions where user_id=' . $this->Auth->user('id') . ' GROUP BY user_id) as info GROUP BY user_id;'));
        $this->set('spent', $this->Wallet->query('SELECT update_date, project_id, project_name, funds FROM transactions, projects where user_id=' . $this->Auth->user('id') . ' and projects.id=transactions.project_id ORDER BY update_date DESC;'));
        if (!empty($this->data)) {
            if (preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $this->data['Wallet']['Amount'])) {
                if (floatval($this->data['Wallet']['Amount']) <= 10000.00) {
                    $this->Wallet->query('INSERT INTO wallets (user_id, payment_method_id, account_number) VALUES (' . $this->Auth->user('id') . ', ' . 1 . ', ' . 0 . ');');
                    $insertID = $this->Wallet->query('SELECT id FROM wallets where user_id=' . $this->Auth->user('id') . ' ORDER BY id DESC LIMIT 1;')[0]['wallets']['id'];
                    $this->Wallet->query('INSERT INTO wallet_transactions (wallet_id, funds) VALUES ('. $insertID . ', ' . floatval($this->data['Wallet']['Amount']) . ');');
                    $this->Session->setFlash('Funds added successfully.');
                    $this->redirect(array('controller'=>'wallets', 'action'=>'index'));
                } else {
                    $this->Session->setFlash('You can only add $10000.00 or less!');
                }
            } else {
                $this->Session->setFlash('Invalid amount.');
            }
        }
    }
    
}
?>