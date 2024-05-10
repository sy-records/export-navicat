<?php

namespace Luffy\ExportNavicat;

class Connection
{
    protected string $file;

    protected int $version;

    protected Password $password;

    public function __construct(string $file, int $version = 12)
    {
        $this->file = $file;
        $this->version = $version;
        $this->password = new Password($version);
    }

    public function getConnections()
    {
        $xml = simplexml_load_file($this->file);
        $connections = [];
        foreach ($xml->Connection as $connection) {
            $attributes = $connection->attributes();
            $password = (string)$attributes['Password'];
            $sshPassword = (string)$attributes['SSH_Password'];
            $dbFile = (string)$attributes['DatabaseFileName'];
            $connType = (string)$attributes['ConnType'];
            $ssh = (string)$attributes['SSH'];

            $result = [
                'type' => $connType,
                'name' => (string)$attributes['ConnectionName'],
                'host' => (string)$attributes['Host'],
                'port' => (string)$attributes['Port'],
                'userName' => (string)$attributes['UserName'],
                'password' => !empty($password) ? $this->password->decrypt($password) : '',
            ];

            if ($ssh != 'false') {
                $result['ssh'] = $ssh;
                $result['sshHost'] = (string)$attributes['SSH_Host'];
                $result['sshPort'] = (string)$attributes['SSH_Port'];
                $result['sshUserName'] = (string)$attributes['SSH_UserName'];
                $result['sshPassword'] = !empty($sshPassword) ? $this->password->decrypt($sshPassword) : '';
            }

            if (!empty($dbFile)) {
                $result['dbFile'] = $dbFile;
            }

            $connections[] = $result;
        }
        return $connections;
    }
}
