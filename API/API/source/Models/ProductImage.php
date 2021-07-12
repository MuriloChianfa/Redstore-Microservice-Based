<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * ProductImage class...
 * 
 * @package \Source\Models\ProductImage
 */
class ProductImage extends Model
{
    /**
     * ProductImage constructor.
     */
    public function __construct()
    {
        parent::__construct('product_image', [ 'id' ], [ 'product_id', 'url_slug', 'real_path' ]);
    }

    /**
     * @param int $product_id
     * @param string $url_slug
     * @param string $real_path
     * @return ProductImage
     */
    public function bootstrap(int $product_id, string $url_slug, string $real_path): ProductImage
    {
        $this->product_id = $product_id;
        $this->url_slug = $url_slug;
        $this->real_path = $real_path;
        return $this;
    }

    /**
     * @param string $slug
     * @param string $columns
     * @return null|ProductImage
     */
    public function findBySlug(string $slug, string $columns = "*"): ?ProductImage
    {
        $find = $this->find("url_slug = :slug", "slug={$slug}", $columns);

        return $find->fetch();
    }

    /**
     * @param int $productId
     * @param string $columns
     * @return array|null
     */
    public function findAllByProductId(int $productId, string $columns = "*"): ?array
    {
        $find = $this->find("product_id = :product_id", "product_id={$productId}", $columns);

        $data = $find->fetch(true);

        if (empty($data)) {
            return [];
        }

        foreach ($data as $key => $value) {
            $data[$key] = $value->data();
        }

        return $data;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->error = "ID do produto, URL Slug e Real Path, são obrigatórios!";
            return false;
        }

        /** ProductImage Update */
        if (!empty($this->id)) {
            $this->update($this->safe(), "id = :id", "id={$this->id}");
            if ($this->fail()) {
                $this->error = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        /** ProductImage Create */
        if (empty($this->id)) {
            $this->id = $this->create($this->safe());

            if ($this->fail()) {
                $this->error = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = ($this->findById($this->id))->data();
        return true;
    }
}
