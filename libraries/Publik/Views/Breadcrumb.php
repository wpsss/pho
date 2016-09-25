<?php namespace Pho\Publik\Views;
/**
 * Breadcrumb
 */
use Pho\Helpers\Html;

final class Breadcrumb extends PublicView
{
  /**
   * Render
   *
   * @param  object  $query  \WP_Query
   */
  function render($query)
  {
    ?><div class="entry-breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#" itemprop="breacrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
      <span typeof="v:Breadcrumb">
        <a rel="v:url" property="v:title" href="<?= home_url() ?>">
          <?= Html::encode( get_option('blogname') ) ?>
        </a>
      </span>
      <?= ' ' . $this->theme->settings['breadcrumb_sep'] ?>
      <span rel="v:child" typeof="v:Breadcrumb">
        <?php $this->theCrumbs($query) ?>
      </span>
    </div><?php
  }

  /**
   * Compile crumbs
   */
  private function theCrumbs(\WP_Query $query)
  {
  	if ($query->is_category) {
  		return $this->theCatCrumb($query);
    } elseif ($query->is_tag) {
      return $this->theTagCrumb($query);
    } elseif ($query->is_tax) {
      return $this->theTaxCrumb($query);
    } elseif ($query->is_year) {
      return $this->theYearCrumb($query);
    } elseif ($query->is_month) {
      return $this->theMonthCrumb($query);
    } elseif ($query->is_day) {
      return $this->theDayCrumb($query);
    } elseif ($query->is_post_type_archive) {
      return $this->thePostTypeArchiveCrumb($query);
    } elseif ($query->is_page) {
  		return $this->thePageCrumb($query);
  	} elseif ($query->is_author) {
  		return $this->theAuthorCrumb($query);
  	} elseif ($query->is_search) {
  		return $this->theSearchCrumb($query);
  	} elseif ($query->is_404) {
      return $this->the404Crumb($query);
    } elseif ( $query->is_single && ('attachment' !== $query->post->post_type) ) {
      return $this->thePostCrumb($query);
    } elseif ($query->is_attachment) {
      return $this->theAttachmentCrumb($query);
    } else {
      return;
    }
  }

  /**
   * Category archive crumb
   */
  private function theCatCrumb(\WP_Query $query, $crumb = '')
  {
    if ($query->queried_object->category_parent)
      $crumb .= $this->getParentTax($query->post, $query->queried_object->category_parent, $this->getSep() );

    echo $this->getTypeCrumb($query) . $crumb . $label = __('Categorized as', 'pho') . ': ' . Html::encode($query->queried_object->name);
  }

  /**
   * Tag archive crumb
   */
  private function theTagCrumb(\WP_Query $query)
  {
    echo $this->getTypeCrumb($query) . __('Tagged with', 'pho') . ': ' . Html::encode($query->queried_object->name);
  }

  /**
   * Custom taxonomy archive crumb
   */
  private function theTaxCrumb(\WP_Query $query)
  {
    echo $this->getTypeCrumb($query) . __('Classified as', 'pho') . ': ' . Html::encode($query->queried_object->name);
  }

  /**
   * Yearly archive crumb
   */
  private function theYearCrumb(\WP_Query $query)
  {
    echo $this->getTypeCrumb($query) . __('Posted in', 'pho') . ': ' . $query->query_vars['year'];
  }

  /**
   * Monthly archive crumb
   */
  private function theMonthCrumb(\WP_Query $query)
  {
    $year = $query->query_vars['year'];
    $month = date_i18n( 'F', mktime(0, 0, 0, $query->query_vars['monthnum'], 1) );

    echo $this->getCrumbLink( get_year_link($year), $year ) . $this->getSep() . __('Posted on', 'pho') . ': ' . $month;
  }

  /**
   * Daily archive crumbs
   */
  private function theDayCrumb(\WP_Query $query)
  {
    $year = $query->query_vars['year'];
    $month = $query->query_vars['monthnum'];
    $yearlink = $this->getCrumbLink( get_year_link($year), $year );
    $localmonth = date_i18n('F', mktime(0, 0, 0, $month, 1) );
    $monthlink = $this->getCrumbLink( get_month_link($year, $month), $localmonth );

    echo $yearlink . $this->getSep() . $monthlink . $this->getSep() . $query->query_vars['day'];
  }

  /**
   * Custom post type archive crumb
   */
  private function thePostTypeArchiveCrumb($query)
  {
    echo $GLOBALS['wp_post_types'][$query->post->post_type]->labels->name;
  }

  /**
   * Author archive crumb
   */
  private function theAuthorCrumb(\WP_Query $query)
  {
    echo __('Posted by', 'pho') . ': ' . $query->queried_object->display_name;
  }

  /**
   * Single page crumb
   */
  private function thePageCrumb(\WP_Query $query, $crumb = '')
  {
    if ($query->post->post_parent) {
      $parent_ids = array_reverse( array_values($query->post->ancestors) );
      foreach ($parent_ids as $id) {
        $crumb .= $this->getCrumbLink( get_permalink($id), get_the_title($id) ) . $this->getSep();
      }
    }

    $crumb .= Html::encode($query->post->post_title);

    echo $crumb;
  }

  /**
   * Search results page crumb
   */
  private function theSearchCrumb(\WP_Query $query)
  {
    echo __('Search results for', 'pho') . ': ' . Html::encode($query->query_vars['s']);
  }

  /**
   * 404 crumb
   */
  private function the404Crumb(\WP_Query $query)
  {
     echo __('404 Not Found', 'pho');
  }

  /**
   * Single post crumb
   */
  private function thePostCrumb(\WP_Query $query, $tax_ids = [], $crumb = '')
  {
    $taxonomies = get_the_terms( $query->post, $this->getHierTax($query->post) );

    if ($taxonomies) {
      foreach ($taxonomies as $tax_obj) {
        $tax_ids[] = $tax_obj->term_id;
      }
      rsort($tax_ids); // To get latest hierarchical taxonomy.
      $crumb .= $this->getParentTax( $query->post, $tax_ids[0], $this->getSep() );
    }

    echo $this->getTypeCrumb($query) . $crumb . Html::encode($query->post->post_title);
  }

  /**
   * Single attachment crumb
   */
  private function theAttachmentCrumb(\WP_Query $query, $crumb = '')
  {
    if ($query->post->post_parent) {
      $parent_post = \WP_Post::get_instance($query->post->post_parent);
      $hierar_tax = $this->getHierTax($parent_post);
      $terms = get_the_terms($parent_post, $hierar_tax);

      if ($terms) $crumb .= $this->getCrumbLink( get_term_link($terms[0]->term_id), $terms[0]->name ) . $this->getSep();

      $crumb .= $this->getCrumbLink( get_permalink($query->post->post_parent), get_the_title($query->post->post_parent) ) . $this->getSep();
    }

    $crumb .= Html::encode($query->post->post_title);

    echo $this->getTypeCrumb($query) . $crumb;
  }

  /**
   * Get crumb link
   *
   * @param   string  $url     The value of href attribute.
   * @param   string  $anchor  The anchor text of crumb link.
   *
   * @return  string
   */
  private function getCrumbLink($url, $anchor)
  {
    return '<a rel="v:url" property="v:title" href="' . $url . '">' . Html::encode($anchor) . '</a>';
  }

  /**
   * Get combo seperator
   *
   * @return  string
   */
  private function getSep()
  {
    return '</span> ' . $this->theme->settings['breadcrumb_sep'] . ' <span rel="v:child" typeof="v:Breadcrumb">';
  }

  /**
   * Get type crumb
   *
   * @return  string
   */
  private function getTypeCrumb(\WP_Query $query)
  {
    $post_type = $query->post->post_type;
    $page_for_posts = get_option('page_for_posts');

    if ( empty($GLOBALS['wp_post_types'][$post_type]) || ( ('post' === $post_type) && !$page_for_posts) ) return;

    $post_type_label = ('post' === $post_type) ? get_the_title($page_for_posts) : $GLOBALS['wp_post_types'][$post_type]->label;

    $post_type_url = ('post' === $post_type) ? get_permalink($page_for_posts) : get_post_type_archive_link($post_type);

    return $this->getCrumbLink($post_type_url, $post_type_label) . $this->getSep();
  }

  /**
   * Get the first hierarchical taxonomy
   *
   * @return  string
   */
  private function getHierTax(\WP_Post $post)
  {
    $taxonomies = (array)$GLOBALS['wp_taxonomies'];

    foreach ($taxonomies as $tax_name => $tax_obj) {
      if ( array_intersect( (array)$post->post_type, (array)$tax_obj->object_type) && $taxonomies[$tax_name]->hierarchical ) {
        return $tax_name;
      } else {
        $tax = false;
      }
    }

    return $tax;
  }

  /**
   * Get parent crumb(s) of a taxonomy recursively
   *
   * @param  int  $id  Term's ID.
   * @param  array  $visited  Visited terms.
   *
   * @return  string
   */
  private function getParentTax(\WP_Post $post, $id, $sep = '/', &$visited = [], $chain = '')
  {
    $hierar_tax = $this->getHierTax($post);
    $parent_term = \WP_Term::get_instance($id, $hierar_tax);

    if ( ($parent_term instanceof WP_Error) || !$parent_term ) return;

    if ( $parent_term->parent && !in_array($parent_term->parent, $visited) ) {
      $visited[] = $parent_term->parent;
      $chain .= $this->getParentTax($post, $parent_term->parent, $this->getSep(), $visited);
    }

    $term_url = get_term_link($parent_term, $hierar_tax);
    $chain .= $this->getCrumbLink($term_url, $parent_term->name) . $this->getSep();

    return $chain;
  }
}
