<?php
if ( !function_exists( 'dwh_head' ) )
{
    function dwh_head()
    {
        do_action('dwh_head');
    }
}

if ( !function_exists( 'dwh_body_hook' ) )
{
    function dwh_body_hook(){
        do_action('dwh_body_hook');
    }
}

if ( !function_exists( 'dwh_header_hook' ) )
{
    function dwh_header_hook()
    {
        do_action('dwh_header_hook');
    }
}

if ( !function_exists( 'dwh_footer_hook' ) )
{
    function dwh_footer_hook()
    {
        do_action('dwh_footer_hook');
    }
}

if ( !function_exists('dwh_content_header_hook') )
{
    function dwh_content_header_hook()
    {
        do_action('dwh_content_header_hook');
    }
}

if ( !function_exists('dwh_content_hook') )
{
    function dwh_content_hook()
    {
        do_action('dwh_content_hook');
    }
}

if ( !function_exists('dwh_content_footer_hook') )
{
    function dwh_content_footer_hook()
    {
        do_action('dwh_content_footer_hook');
    }
}