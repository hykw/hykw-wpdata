<?php

class sample extends WP_UnitTestCase {

    public function test_rewrite()
    {   
#        $this->go_to( '/hoge/' );
        $this->go_to( '/' );
        $this->assertQueryTrue( 'is_home' ); // is_singular()なら合格

#        $this->assertTrue(FALSE);
    }   
}
