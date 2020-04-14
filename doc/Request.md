
        dump( $this->request()->base() );
        dump( $this->request()->hostname() );
        dump( $this->request()->port() );
        dump( $this->request()->uri() );
        dump( $this->request()->path() );
        dump( $this->request()->query()->get('email') );
        dump( $this->request()->request()->get('email') );
        dump( $this->request()->scheme() );
        dump( $this->request()->method() );
        dump( $this->request()->agent() );
        dump( $this->request()->referer() );
        dump( $this->request()->isGet() );
        dump( $this->request()->isPost() );