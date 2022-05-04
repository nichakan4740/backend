package sit.int221.oasip.Repository;

import org.springframework.data.jpa.repository.JpaRepository;
import sit.int221.oasip.Entity.Eventcategory;

public interface EventCategoryRepository extends JpaRepository<Eventcategory, Integer> {
}
