package sit.int221.oasip.Repository;

import org.springframework.data.jpa.repository.JpaRepository;
import sit.int221.oasip.Entity.Categories;

public interface CategoriesRepository extends JpaRepository<Categories, Integer> {
}
